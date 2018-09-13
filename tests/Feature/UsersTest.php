<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $userData;
    protected $password;

    public function setUp()
    {
        parent::setUp();

        $this->password = 'password';
        $this->userData = [
            'name' => 'Ivan Petrov',
            'email' => 'ivan@example.com',
            'password' => Hash::make($this->password),
        ];

        $this->user = factory(User::class)->create($this->userData);
    }

    public function testGetUserLoginForm()
    {
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    public function testUserLogin()
    {
        $response = $this->post(route('login'), array_merge(
            $this->userData,
            ['password' => $this->password]
        ));

        $response->assertRedirect(route('home'));
    }

    public function testUserLogout()
    {
        $response = $this->actingAs($this->user)->post('logout');

        $response->assertRedirect(route('index'));
    }

    public function testGetUserRegistrationForm()
    {
        $response = $this->get(route('register'));

        $response->assertOk();
    }

    public function testUserRegistration()
    {
        $userData = [
            'name' => 'New User',
            'email' => 'new@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('register'), $userData);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', ['email' => $userData['email']]);
    }

    public function testUsersViewWithoutAuth()
    {
        $response = $this->get('users');

        $response->assertRedirect('login');
    }

    public function testUsersViewWithAuth()
    {
        $response = $this->actingAs($this->user)->get('users');

        $response->assertOk();
        $response->assertSeeText($this->user->email);
    }

    public function testGetPasswordResetRequestForm()
    {
        $response = $this->get(route('password.request'));

        $response->assertOk();
    }

    public function testSendsPasswordResetEmail()
    {

        $this->expectsNotification($this->user, ResetPassword::class);

        $response = $this->post(route('password.email'), $this->userData);

        $response->assertStatus(302);
    }

    public function testDoesNotSendPasswordResetEmail()
    {
        $this->doesntExpectJobs(ResetPassword::class);

        $response = $this->post(route('password.email'), ['email' => 'invalidemail@example.com']);

        $response->assertSessionHasErrors();
    }

    public function testGetPasswordResetForm()
    {
        $response = $this->get(route('password.reset', ['token' => 'token']));

        $response->assertOk();
    }

    public function testChangeUserPassword()
    {
        $token = Password::createToken($this->user);
        $newpassword = 'newpassword';

        $response = $this->post(route('password.request'), [
            'email' => $this->user->email,
            'password' => $newpassword,
            'password_confirmation' => $newpassword,
            'token' => $token,
        ]);

        $this->assertTrue(Hash::check($newpassword, $this->user->fresh()->password));
    }
}

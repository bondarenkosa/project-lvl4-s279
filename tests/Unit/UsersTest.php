<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testUserRegistration()
    {
        $response = $this->post(route('register'), $this->validParams());

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', ['email' => $this->validParams()['email']]);
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

    public function testUserAccountEdit()
    {
        $response = $this->actingAs($this->user)->get(route('account.edit'));

        $response->assertOk();
    }

    public function testResetPassword()
    {
        $response = $this->actingAs($this->user)->post(route('account.changepassword'));

        $response->assertSessionHasNoErrors();
    }

    public function testUserAccountDelete()
    {
        $this->assertDatabaseHas('users', ['email' => $this->user->email]);

        $response = $this->actingAs($this->user)->call('DELETE', route('account.delete'));

        $this->assertDatabaseMissing('users', ['email' => $this->user->email]);
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'name' => 'Ivan Petrov',
            'email' => 'ivan@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ], $overrides);
    }
}

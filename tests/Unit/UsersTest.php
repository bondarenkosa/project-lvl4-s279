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

    public function testUserRegistration()
    {
        $user =  [
            'name' => 'Test Name',
            'email' => 'test@mail4app.com',
            'password' => 'passwordtest',
            'password_confirmation' => 'passwordtest'
        ];
        $response = $this->post('/register', $user);

        $response->assertRedirect('/home');
        $this->assertDatabaseHas('users', ['email' => $user['email']]);
    }

    public function testUsersViewWithoutAuth()
    {
        $response = $this->get('users');

        $response->assertRedirect('login');
    }

    public function testUsersViewWithAuth()
    {
        $email = 'user@mail4app.com';
        $user = factory(User::class)->create(compact('email'));

        $response = $this->actingAs($user)->get('users');

        $response->assertOk();

        $response->assertSeeText($email);
    }

    public function testUserAccountEdit()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('account/edit');

        $response->assertOk();
    }
}

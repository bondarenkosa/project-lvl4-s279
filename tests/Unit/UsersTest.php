<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

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
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get('users');

        $response->assertOk();
        $response->assertSeeText($user->email);
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

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

    public function testUsersViewWithoutAuth()
    {
        $response = $this->get('users');

        $response->assertRedirect('login');
    }

    public function testUsersViewWithAuth()
    {
        $email = 'user@mail4app.com';
        $user = factory(User::class)->create(compact('email'));

        $response = $this->actingAs($user)
                         ->get('users');

        $response->assertOk();

        $response->assertSeeText($email);
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $userData;

    public function setUp()
    {
        parent::setUp();

        $this->userData = [
            'name' => 'Ivan Petrov',
            'email' => 'ivan@example.com',
        ];

        $this->user = factory(User::class)->create($this->userData);
    }

    public function testGetAccountEditPage()
    {
        $response = $this->actingAs($this->user)->get(route('account.edit'));

        $response->assertOk();
    }

    public function testAccountPatch()
    {
        $newData = [
            'name' => 'Edited UserName',
            'email' => $this->user->email,
        ];

        $response = $this->actingAs($this->user)->call('PATCH', route('account'), $newData);

        $this->assertDatabaseHas('users', $newData);
    }

    public function testResetPassword()
    {
        $response = $this->actingAs($this->user)->post(route('account.changepassword'));

        $response->assertSessionHasNoErrors();
    }

    public function testAccountDelete()
    {
        $this->assertDatabaseHas('users', $this->userData);

        $response = $this->actingAs($this->user)->call('DELETE', route('account'));

        $this->assertDatabaseMissing('users', $this->userData);
    }
}

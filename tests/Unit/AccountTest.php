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

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    public function testAccountEdit()
    {
        $response = $this->actingAs($this->user)->get(route('account.edit'));

        $response->assertOk();
    }

    public function testResetPassword()
    {
        $response = $this->actingAs($this->user)->post(route('account.changepassword'));

        $response->assertSessionHasNoErrors();
    }

    public function testAccountDelete()
    {
        $this->assertDatabaseHas('users', ['email' => $this->user->email]);

        $response = $this->actingAs($this->user)->call('DELETE', route('account'));

        $this->assertDatabaseMissing('users', ['email' => $this->user->email]);
    }
}

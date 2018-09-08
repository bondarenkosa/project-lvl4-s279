<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PagesTest extends TestCase
{
    use WithoutMiddleware;
    
    /**
     * Test index page.
     *
     * @return void
     */
    public function testIndexPage()
    {
        $response = $this->get('/');

        $response->assertOk();
    }

    public function testHomePage()
    {
        $response = $this->get(route('home'));

        $response->assertOk();
    }
}

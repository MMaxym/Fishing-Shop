<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserMainPageTest extends TestCase
{
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    public function test_user_main_page_exists()
    {
        $response = $this->get(route('user.main'));

        $response->assertStatus(200);
    }
}

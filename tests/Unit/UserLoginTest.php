<?php
// tests/Unit/UserLoginTest.php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_login_success()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('passworD1%'),
        ]);

        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'passworD1%',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('passworD1%'),
        ]);

        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHas('status');
        $this->assertGuest();
    }
}

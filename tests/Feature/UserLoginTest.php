<?php
// tests/Feature/UserLoginTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
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

    public function test_login_fails_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => bcrypt('passworD1%'),
        ]);

        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'wrongpassword',
        ]);

        //we are checking for error in the session since this is the way 
        //an error message is returned back to the user in my application (basically session flashing)
        $response->assertSessionHas('error');
        $this->assertGuest();
    }
}

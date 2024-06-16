<?php
// tests/Unit/UserRegistrationTest.php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration_success()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passworD1%',
            'passwordConfirmation' => 'passworD1%',
        ]);


        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);
    }

    public function test_user_registration_with_invalid_email()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'password' => 'passworD1%',
            'passwordConfirmation' => 'passworD1%',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_registration_with_mismatched_passwords()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passworD1%',
            'passwordConfirmation' => 'not-the-same-password',
        ]);

        $response->assertSessionHasErrors('passwordConfirmation');
    }
    public function test_user_registration_with_not_strong_password()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passworD%',
            'passwordConfirmation' => 'passworD%',
        ]);

        $response->assertSessionHasErrors('password');

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passwor1%',
            'passwordConfirmation' => 'passwor1%',
        ]);

        $response->assertSessionHasErrors('password');

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passworD1',
            'passwordConfirmation' => 'passworD1',
        ]);

        $response->assertSessionHasErrors('password');

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'pasrD1%',
            'passwordConfirmation' => 'pasrD1%',
        ]);

        $response->assertSessionHasErrors('password');

    }
}

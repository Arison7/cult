<?php
// tests/Feature/UserRegistrationTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passworD1%',
            'passwordConfirmation' => 'passworD1%',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }


    public function test_registration_fails_with_invalid_email()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'not-an-email',
            'password' => 'passworD1%',
            'passwordConfirmation' => 'passworD1%',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_registration_fails_with_mismatched_passwords()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passworD1%',
            'passwordConfirmation' => 'not-the-same-password',
        ]);

        $response->assertSessionHasErrors('passwordConfirmation');
        $this->assertGuest();
    }

    public function test_registration_fails_with_not_strong_password()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passworD%',
            'passwordConfirmation' => 'passworD%',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passwor1%',
            'passwordConfirmation' => 'passwor1%',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'passworD1',
            'passwordConfirmation' => 'passworD1',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'pasrD1%',
            'passwordConfirmation' => 'pasrD1%',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }
}

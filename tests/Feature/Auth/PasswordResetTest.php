<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_is_disabled_and_redirects_to_login(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertRedirect('/login');
    }

    public function test_forgot_password_post_is_disabled(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/forgot-password', ['email' => $user->email]);

        $response->assertRedirect('/login');
    }

    public function test_reset_password_screen_is_disabled(): void
    {
        $response = $this->get('/reset-password/sample-token');

        $response->assertRedirect('/login');
    }

    public function test_reset_password_post_is_disabled(): void
    {
        $response = $this->post('/reset-password', [
            'token' => 'sample-token',
            'email' => 'test@example.com',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect('/login');
    }
}

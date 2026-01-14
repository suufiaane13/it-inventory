<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que la route d'inscription est désactivée.
     * L'inscription publique est désactivée dans ce projet.
     * Seuls les super admins peuvent créer des comptes via /users.
     */
    public function test_registration_screen_is_disabled(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(404);
    }

    /**
     * Test que l'inscription via POST est désactivée.
     */
    public function test_registration_is_disabled(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(404);
        $this->assertGuest();
    }
}

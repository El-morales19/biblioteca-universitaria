<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InactiveUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_user_is_redirected_to_account_disabled_page()
    {
        $user = User::factory()->create([
            'role' => 'alumno',
            'active' => false,
        ]);

        // Attempt to access the dashboard
        $response = $this->actingAs($user)->get('/dashboard');

        // Should be intercepted and redirected
        $response->assertRedirect(route('account.disabled'));
    }

    public function test_inactive_user_can_view_account_disabled_page()
    {
        $user = User::factory()->create([
            'role' => 'alumno',
            'active' => false,
        ]);

        // Attempt to access the disabled page directly
        $response = $this->actingAs($user)->get(route('account.disabled'));

        // Should be allowed to see it
        $response->assertStatus(200);
        $response->assertSee('Cuenta Desactivada');
        $response->assertSee('Cerrar Sesión');
    }

    public function test_active_user_cannot_view_account_disabled_page()
    {
        $user = User::factory()->create([
            'role' => 'alumno',
            'active' => true, // User is active
        ]);

        // Attempt to access the disabled page
        $response = $this->actingAs($user)->get(route('account.disabled'));

        // Active users shouldn't be here, redirect back to dashboard
        $response->assertRedirect('/dashboard');
    }

    public function test_guest_is_redirected_to_login()
    {
        // Unauthenticated user attempting to view the disabled page
        $response = $this->get(route('account.disabled'));

        $response->assertRedirect(route('login'));
    }
}

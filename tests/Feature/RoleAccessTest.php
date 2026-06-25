<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_has_full_access()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $this->actingAs($admin)->get('/users')->assertStatus(200);
        $this->actingAs($admin)->get('/books')->assertStatus(200);
        $this->actingAs($admin)->get('/loans')->assertStatus(200);
        $this->actingAs($admin)->get('/reports')->assertStatus(200);
    }

    public function test_bibliotecario_restricted_access()
    {
        $bibliotecario = User::factory()->create([
            'role' => 'bibliotecario',
            'active' => true,
        ]);

        $this->actingAs($bibliotecario)->get('/users')->assertStatus(403);
        $this->actingAs($bibliotecario)->get('/books')->assertStatus(200);
        $this->actingAs($bibliotecario)->get('/loans')->assertStatus(200);
        $this->actingAs($bibliotecario)->get('/reports')->assertStatus(200);
    }

    public function test_alumno_restricted_access()
    {
        $alumno = User::factory()->create([
            'role' => 'alumno',
            'active' => true,
        ]);

        $this->actingAs($alumno)->get('/users')->assertStatus(403);
        $this->actingAs($alumno)->get('/books')->assertStatus(200);
        $this->actingAs($alumno)->get('/books/create')->assertStatus(403);
        $this->actingAs($alumno)->get('/loans')->assertStatus(200);
        $this->actingAs($alumno)->get('/loans/create')->assertStatus(403);
        $this->actingAs($alumno)->get('/reports')->assertStatus(200);
    }
}

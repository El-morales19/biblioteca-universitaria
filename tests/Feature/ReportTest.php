<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_global_reports()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $student = User::factory()->create([
            'role' => 'alumno',
            'active' => true,
        ]);

        $book1 = Book::create([
            'title' => 'Test Book 1',
            'author' => 'Author 1',
            'isbn' => '1234567890',
            'available' => false,
            'active' => true,
        ]);

        $book2 = Book::create([
            'title' => 'Test Book 2',
            'author' => 'Author 2',
            'isbn' => '0987654321',
            'available' => true,
            'active' => true,
        ]);

        Loan::create([
            'user_id' => $student->id,
            'book_id' => $book1->id,
            'loan_date' => now()->subDays(5),
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->get('/reports');

        $response->assertStatus(200);
        $response->assertViewHas('isStudentReport', false);
        $response->assertViewHas('totalActiveBooks', 2);
        $response->assertViewHas('availableBooks', 1);
        $response->assertViewHas('unavailableBooks', 1);
        $response->assertViewHas('totalLoans', 1);
        $response->assertViewHas('activeLoans', 1);
        $response->assertSee('Usuarios con préstamos activos');
        $response->assertSee('Test Book 1');
    }

    public function test_bibliotecario_can_view_global_reports()
    {
        $bibliotecario = User::factory()->create([
            'role' => 'bibliotecario',
            'active' => true,
        ]);

        $response = $this->actingAs($bibliotecario)->get('/reports');

        $response->assertStatus(200);
        $response->assertViewHas('isStudentReport', false);
        $response->assertSee('Usuarios con préstamos activos');
    }

    public function test_alumno_can_view_personal_reports_only()
    {
        $student1 = User::factory()->create([
            'role' => 'alumno',
            'active' => true,
        ]);

        $student2 = User::factory()->create([
            'role' => 'alumno',
            'active' => true,
        ]);

        $book1 = Book::create([
            'title' => 'Book 1',
            'author' => 'Author 1',
            'isbn' => '1111111111',
            'available' => false,
            'active' => true,
        ]);

        $book2 = Book::create([
            'title' => 'Book 2',
            'author' => 'Author 2',
            'isbn' => '2222222222',
            'available' => false,
            'active' => true,
        ]);

        Loan::create([
            'user_id' => $student1->id,
            'book_id' => $book1->id,
            'loan_date' => now()->subDays(2),
            'status' => 'active',
        ]);

        Loan::create([
            'user_id' => $student2->id,
            'book_id' => $book2->id,
            'loan_date' => now()->subDays(1),
            'status' => 'active',
        ]);

        $response = $this->actingAs($student1)->get('/reports');

        $response->assertStatus(200);
        $response->assertViewHas('isStudentReport', true);
        $response->assertViewHas('totalActiveBooks', null);
        $response->assertViewHas('availableBooks', null);
        $response->assertViewHas('unavailableBooks', 1);
        $response->assertViewHas('totalLoans', 1);
        $response->assertViewHas('activeLoans', 1);
        $response->assertSee('Libros con préstamo activo');
        $response->assertSee('Book 1');
        $response->assertDontSee('Book 2');
    }
}

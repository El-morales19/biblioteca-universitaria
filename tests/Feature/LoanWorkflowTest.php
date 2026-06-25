<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_loan_view_only_lists_active_alumnos_ordered_by_name()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $activeAlumno2 = User::factory()->create([
            'name' => 'Zachary Student',
            'role' => 'alumno',
            'active' => true,
        ]);

        $activeAlumno1 = User::factory()->create([
            'name' => 'Alice Student',
            'role' => 'alumno',
            'active' => true,
        ]);

        $inactiveAlumno = User::factory()->create([
            'name' => 'Inactive Student',
            'role' => 'alumno',
            'active' => false,
        ]);

        $bibliotecario = User::factory()->create([
            'name' => 'Librarian User',
            'role' => 'bibliotecario',
            'active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/loans/create');

        $response->assertStatus(200);
        
        $usersInView = $response->viewData('users');
        
        $this->assertCount(2, $usersInView);
        $this->assertEquals($activeAlumno1->id, $usersInView[0]->id);
        $this->assertEquals($activeAlumno2->id, $usersInView[1]->id);
        
        $response->assertSee('Alice Student');
        $response->assertSee('Zachary Student');
        $response->assertDontSee('Inactive Student');
        $response->assertDontSee('Librarian User');
    }

    public function test_store_loan_allows_active_alumno()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $alumno = User::factory()->create([
            'role' => 'alumno',
            'active' => true,
        ]);

        $book = Book::create([
            'title' => 'Test Book',
            'author' => 'Author',
            'isbn' => '9999999999',
            'available' => true,
            'active' => true,
        ]);

        $response = $this->actingAs($admin)->post('/loans', [
            'user_id' => $alumno->id,
            'book_id' => $book->id,
            'loan_date' => now()->toDateString(),
        ]);

        $response->assertRedirect(route('loans.index'));
        $this->assertDatabaseHas('loans', [
            'user_id' => $alumno->id,
            'book_id' => $book->id,
            'status' => 'active',
        ]);
    }

    public function test_store_loan_forbids_non_alumno_or_inactive_user()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $bibliotecario = User::factory()->create([
            'role' => 'bibliotecario',
            'active' => true,
        ]);

        $inactiveAlumno = User::factory()->create([
            'role' => 'alumno',
            'active' => false,
        ]);

        $book = Book::create([
            'title' => 'Test Book',
            'author' => 'Author',
            'isbn' => '9999999999',
            'available' => true,
            'active' => true,
        ]);

        $response = $this->actingAs($admin)->post('/loans', [
            'user_id' => $bibliotecario->id,
            'book_id' => $book->id,
            'loan_date' => now()->toDateString(),
        ]);

        $response->assertSessionHasErrors('user_id');

        $response2 = $this->actingAs($admin)->post('/loans', [
            'user_id' => $inactiveAlumno->id,
            'book_id' => $book->id,
            'loan_date' => now()->toDateString(),
        ]);

        $response2->assertSessionHasErrors('user_id');
    }

    public function test_returning_loan_marks_book_as_available()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'active' => true,
        ]);

        $alumno = User::factory()->create([
            'role' => 'alumno',
            'active' => true,
        ]);

        $book = Book::create([
            'title' => 'Returned Book',
            'author' => 'Author',
            'isbn' => '3333333333',
            'available' => false,
            'active' => true,
        ]);

        $loan = Loan::create([
            'user_id' => $alumno->id,
            'book_id' => $book->id,
            'loan_date' => now()->subDays(3)->toDateString(),
            'status' => 'active',
        ]);

        $response = $this->actingAs($admin)->patch("/loans/{$loan->id}", [
            'user_id' => $alumno->id,
            'book_id' => $book->id,
            'loan_date' => $loan->loan_date,
            'status' => 'returned',
        ]);

        $response->assertRedirect(route('loans.index'));

        $this->assertDatabaseHas('loans', [
            'id' => $loan->id,
            'status' => 'returned',
        ]);

        $this->assertNotNull($loan->fresh()->return_date);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'available' => true,
        ]);
    }
}

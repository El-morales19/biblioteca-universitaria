<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            ['title' => 'Ingeniería de Software', 'author' => 'Ian Sommerville', 'isbn' => '9786073206037', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'isbn' => '9780132350884', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Design Patterns', 'author' => 'Erich Gamma, Richard Helm, Ralph Johnson, John Vlissides', 'isbn' => '9780201633610', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'The Pragmatic Programmer', 'author' => 'Andrew Hunt, David Thomas', 'isbn' => '9780201616224', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Introduction to Algorithms', 'author' => 'Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein', 'isbn' => '9780262033848', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Database System Concepts', 'author' => 'Abraham Silberschatz, Henry F. Korth, S. Sudarshan', 'isbn' => '9780073523323', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Computer Networking: A Top-Down Approach', 'author' => 'James F. Kurose, Keith W. Ross', 'isbn' => '9780133594140', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Artificial Intelligence: A Modern Approach', 'author' => 'Stuart Russell, Peter Norvig', 'isbn' => '9780134610993', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Operating System Concepts', 'author' => 'Abraham Silberschatz, Peter B. Galvin, Greg Gagne', 'isbn' => '9781118063330', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Software Requirements', 'author' => 'Karl Wiegers, Joy Beatty', 'isbn' => '9780735679665', 'available' => true, 'active' => true, 'created_at' => now(), 'updated_at' => now()],
        ];

        \App\Models\Book::insert($books);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        
        $books = Book::where('active', true)->orderBy('created_at', 'desc')->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn',
            'available' => 'boolean',
        ]);

       
        $validated['available'] = $request->has('available'); 

        $validated['active'] = true;

        Book::create($validated);
        

        return redirect()->route('books.index')->with('success', 'Libro creado exitosamente.');
    }


    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }


    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'available' => 'boolean',
        ]);

        $validated['available'] = $request->has('available');

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Libro actualizado exitosamente.');
    }

    public function destroy(Book $book)
    {
        $book->update([
            'active' => false,
            'available' => false
        ]);

        return redirect()->route('books.index')->with('success', 'El libro ha sido dado de baja correctamente.');
    }
}

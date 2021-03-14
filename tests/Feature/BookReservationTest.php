<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A book can be added to library
     * @test
     * @return void
     */
    public function a_book_can_be_added_to_the_library()
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
          'title' => 'First Book',
          'author' => 'John Doe'
        ]);

        $book = Book::first();

        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

     /**
     * a_book_title_is_required
     * @test
     * @return void
     */
    public function a_book_title_is_required()
    {
        $response = $this->post('/books', [
          'title' => '',
          'author' => 'John Doe'
        ]);
        $response->assertSessionHasErrors('title');
    }

    /**
     * a_book_author_is_required
     * @test
     * @return void
     */
    public function a_book_author_is_required()
    {
        $response = $this->post('/books', [
          'title' => 'Book Title',
          'author' => ''
        ]);
        $response->assertSessionHasErrors('author');
    }

    /**
     * a_book-can_be_updated
     * @test
     * @return void
     */
    public function a_book_can_be_updated()
    {
        // $this->withoutExceptionHandling();
        $this->post('/books', [
          'title' => 'First Book',
          'author' => 'John Doe'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
          'title' => 'Updated Title Book',
          'author' => 'New author'
        ]);

        $this->assertEquals('Updated Title Book', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }

    /**
     * a_book_can_be_deleted
     * @test
     */
    public function a_book_can_be_deleted()
    {
        // $this->withoutExceptionHandling();
        $this->post('/books', [
          'title' => 'First Book',
          'author' => 'John Doe'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;

class BookManagementTest extends TestCase
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
        $response = $this->post('/books', $this->data());

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
          'author_id' => 'John Doe'
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
        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));
        $response->assertSessionHasErrors('author_id');
    }

    /**
     * a_book-can_be_updated
     * @test
     * @return void
     */
    public function a_book_can_be_updated()
    {
        // $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
          'title' => 'Updated Title Book',
          'author_id' => 'New author'
        ]);

        $this->assertEquals('Updated Title Book', Book::first()->title);
        $this->assertEquals(2, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }

    /**
     * a_book_can_be_deleted
     * @test
     */
    public function a_book_can_be_deleted()
    {
        // $this->withoutExceptionHandling();
        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete('/books/' . $book->id);
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    /**
     * a_new_author_is_automatically_added
     * @test
     */
    public function a_new_author_is_automatically_added()
    {
        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    private function data()
    {
        return [
            'title' => 'First Book',
            'author_id' => 'John Doe'
        ];
    }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use App\Models\Author;

class BookTest extends TestCase
{
    use RefreshDatabase;

    /**
     * an_author_id_is_recorded
     * @test
     */
    public function an_author_id_is_recorded()
    {

        // $author = Author::firstOrCreate([
        //     'name' => 'John Doe'
        // ]);

        Book::create([
            'title' => 'Cool title',
            'author_id' => 1
        ]);

        // $this->assertCount(1, Author::all());
        $this->assertCount(1, Book::all());
    }
}

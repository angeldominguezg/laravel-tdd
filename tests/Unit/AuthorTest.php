<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Author;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function only_nme_is_required_to_create_an_author()
    {
        Author::firstOrCreate([
            'name' => 'John Doe'
        ]);

        $this->assertCount(1, Author::all());
    }
}

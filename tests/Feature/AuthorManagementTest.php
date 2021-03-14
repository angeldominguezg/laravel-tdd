<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    /**
     * @test
     */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/author', [
            'name' => 'John Doe',
            'dob' => '11-02-2021'
          ]);

        $this->assertCount(1, Author::all());
    }
}

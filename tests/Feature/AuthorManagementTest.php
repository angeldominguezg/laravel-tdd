<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Author;
use Carbon\Carbon;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/author', [
            'name' => 'John Doe',
            'dob' => '05/14/1988'
        ]);

        $auhtor = Author::all();

        $this->assertCount(1, $auhtor);
        $this->assertInstanceOf(Carbon::class, $auhtor->first()->dob);
        $this->assertEquals('1988/05/14', $auhtor->first()->dob->format('Y/m/d'));
    }
}

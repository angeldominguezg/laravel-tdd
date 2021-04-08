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
        // $this->withoutExceptionHandling();
        $response = $this->post('/authors', $this->data());

        $auhtor = Author::all();

        $this->assertCount(1, $auhtor);
        $this->assertInstanceOf(Carbon::class, $auhtor->first()->dob);
        $this->assertEquals('1988/05/14', $auhtor->first()->dob->format('Y/m/d'));
    }

    /**
     * @test
     */
    public function a_name_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));
        $response->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function a_dob_is_required()
    {
        $response = $this->post('/authors', array_merge($this->data(), ['dob' => '']));
        $response->assertSessionHasErrors('dob');
    }

    private function data()
    {
        return [
            'name' => 'John Doe',
            'dob' => '05/14/1988'
        ];
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;

class BookCheckoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_checked_out_by_signed_in_user()
    {
        // $this->withoutExceptionHandling();
        $book = Book::factory()->create();
        $this->actingAs($user = User::factory()->create())->post('/checkout/' . $book->id);

        $this->assertCount(1, Reservation::all());
        $this->assertEquals($user->id, Reservation::first()->user_id);
        $this->assertEquals($book->id, Reservation::first()->book_id);
        $this->assertEquals(now(), Reservation::first()->checked_out_at);
    }

    /** @test */
    public function only_signed_in_users_can_checked_out_a_book()
    {
        // $this->withoutExceptionHandling();

        $book = Book::factory()->create();
        $this->post('/checkout/' . $book->id)->assertRedirect('/login');

        $this->assertCount(0, Reservation::all());
    }

    /** @test */
    public function only_real_book_can_be_checked_out()
    {
        $this->actingAs($user = User::factory()->create())
            ->post('/checkout/123132')
            ->assertStatus(404);

        $this->assertCount(0, Reservation::all());
    }
}

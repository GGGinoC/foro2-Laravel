<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_threads()
    {
        $response = $this->get('/threads/create');
        $response->assertRedirect('/login');

        $response = $this->post('/threads');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_make_their_own_threads()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        
        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());
        
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }


    /** @test */
    public function  a_thread_requires_a_title()
    {
        $this->publishThread(['title'=> null])
            ->assertSessionHasErrors('title');

    }
    
    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body'=> null])
        ->assertSessionHasErrors('body');
    }
    
    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id'=> null])
        ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id'=> 999])
        ->assertSessionHasErrors('channel_id');
    }




    public function publishThread($overrides = [])
    {
        $this->signIn();
        $thread = make('App\Thread', $overrides);
        return $this->post('/threads', $thread->toArray());
    }



}

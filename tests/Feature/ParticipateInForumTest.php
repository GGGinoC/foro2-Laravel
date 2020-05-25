<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
    
    // public function setUp():void
    // {
    //     parent::setUp();
    //     $this->thread = factory('App\Thread')->create();

    // }
    
    
    /** @test */ 
    public function unauthenticated_user_may_not_add_replies()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('threads/1/replies', []);
        
    }
    


    
    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        //create user
        $user = factory('App\User')->create();
        //authentification
        $this->be($user);
        
        $thread = factory('App\Thread')->create();
        
        $reply = factory('App\Reply')->make();
        $this->post($thread->path() . '/replies', $reply->toArray());
      
        $this->get($thread->path())
            ->assertSee($reply->body);

    }
}

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
    public function guest_may_not_make_threads()
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        
        
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
    }



    /** @test */
    public function an_authenticated_user_can_make_their_own_threads()
    {
        $this->withoutExceptionHandling();
        // dado que tenemos un usuario autentificado
        $this->signIn();
        
        // cuando creamos un hilo nuevo
        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
        
        // entonces, cuando visitamos la pagina de hilos
        $response = $this->get($thread->path());

        // deberiamos ver el nuevo hilo creado 
        $response->assertSee($thread->title)
            ->assertSee($thread->body);



    }

}

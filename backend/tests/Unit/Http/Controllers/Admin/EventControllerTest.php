<?php

namespace Tests\Feature\Unit\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Admin\EventController;
use Mockery;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /* public function testExample()
    {
        //Criando objetos
        $event1 = Event::create([
            'id' => '1',
            'name' => 'Evento1',
            'date' => '',
            'place' => 'Local1',
            'city' => 'Cidade1',
            ]);
            
        $event2 = Event::create([
            'id' => '2',
            'name' => 'Evento2',
            'date' => '',
            'place' => 'Local2',
            'city' => 'Cidade2',
        ]);
        
        //Mockando Event
        $this->mock(Event::class, function ($mock) use ($event1, $event2) {
            $mock->shouldReceive('all')->once()->andReturn([$event1, $event2]);
        });
        
        //Testando Rota
        $this->getJson('/api/admin/events')
            ->assertStatus(200)
            ->assertJson([$event1->toArray(), $event2->toArray()]);
    } */

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        //Criando objetos
        $event1 = Event::create([
            'name' => 'Evento1',
            'date' => '',
            'place' => 'Local1',
            'city' => 'Cidade1',
            'id' => '1',
            ]);
            
        $event2 = Event::create([
            'name' => 'Evento2',
            'date' => '',
            'place' => 'Local2',
            'city' => 'Cidade2',
            'id' => '2',
        ]);
        
        //Mockando Event
        $this->mock(Event::class, function ($mock) use ($event1, $event2) {
            $mock->shouldReceive('all')->once()->andReturn([$event1, $event2]);
        });

        $eventController = new EventController(new Event());

        $response = $eventController->index();
        $arrayResponse = json_decode($response->getContent(), true);
        //dd($arrayResponse);
        //dd($response->getContent());
        //dd(json_encode([$event1, $event2]));
        //dd([$event1->toArray(), $event2->toArray()]);
        //$this->assertEquals($arrayResponse, [$event1->toArray(), $event2->toArray()]);
        $this->assertFalse(array_diff($arrayResponse, [$event1->toArray(), $event2->toArray()]));
    }
}

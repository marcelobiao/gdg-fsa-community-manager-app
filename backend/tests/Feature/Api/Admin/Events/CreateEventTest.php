<?php

namespace Tests\Feature\Unit\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Admin\EventController;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class ShowEventTest extends TestCase
{ 

    /**
     * Testa a criação de um novo Event
     *
     * @return void
     */
    public function testCreateEvent()
    {
        //Criando objetos
        $eventsModel = new Collection([
            Event::create([
                'name' => 'Evento1',
                'date' => '',
                'place' => 'Local1',
                'city' => 'Cidade1',
                'id' => '1',
            ]),
            Event::create([
                'name' => 'Evento2',
                'date' => '',
                'place' => 'Local2',
                'city' => 'Cidade2',
                'id' => '2',
            ])
        ]);
        
        //Mockando Event
        $this->mock(Event::class, function ($mock) use ($eventsModel) {
            $mock->shouldReceive('find')
                ->with(1)
                ->andReturn($eventsModel[0]);
            $mock->shouldReceive('find')
                ->with(2)
                ->andReturn($eventsModel[1]);
        });

        //Testando Rota
        $this->getJson('/api/admin/events/1')
            ->assertStatus(200)
            ->assertJson($eventsModel[0]->toArray());

        $this->getJson('/api/admin/events/2')
            ->assertStatus(200)
            ->assertJson($eventsModel[1]->toArray());
    }
}

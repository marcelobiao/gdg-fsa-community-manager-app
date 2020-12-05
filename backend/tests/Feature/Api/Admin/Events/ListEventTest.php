<?php

namespace Tests\Feature\Unit\Http\Controllers\Admin;

use App\Event;
use App\Http\Controllers\Admin\EventController;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class ListEventTest extends TestCase
{
    
    /**
     * Testar listagem de events sem filtro
     *
     * @return void
     */
    public function testListEvents()
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
            $mock->shouldReceive('all')->once()->andReturn($eventsModel);
        });

        //Testando Rota
        $this->getJson('/api/admin/events')
            ->assertStatus(200)
            ->assertJson($eventsModel->toArray());
    }
}

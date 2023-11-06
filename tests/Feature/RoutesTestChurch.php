<?php

namespace Tests\Feature;

use Database\Factories\ChurchFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTestChurch extends TestCase
{   

    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $response = $this->get('/api/church');

        $response->assertStatus(200);
    }

    public function testCreate():void
    {   
        $churchFactory = new ChurchFactory();

        $data = $churchFactory->definition();

        $response = $this->post('/api/church/create', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('churchs', $data);

    }

    public function testCreateStatus422():void
    {   
        $churchFactory = new ChurchFactory();

        $data = $churchFactory->definition();

        $data['name'] = '';
        
        $response = $this->post('/api/church/create', $data);

        $response->assertStatus(422);
    }

    public function testEdit():void
    {
        $response = $this->get('/api/church/edit/1');

        $response->assertStatus(200);
    }

    public function testUpdate():void
    {
        $churchFactory = new ChurchFactory();

        $data = $churchFactory->definition();

        $response = $this->put('/api/church/update/1', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('churchs', $data);
    }

    public function testUpdateStatus422():void
    {
        $churchFactory = new ChurchFactory();

        $data = $churchFactory->definition();

        $data['name'] = "";

        $response = $this->put('/api/church/update/1', $data);

        $response->assertStatus(422);
    }

  /*  public function testDelete():void
    {
        $response = $this->delete('/api/church/delete/22');

        $response->assertStatus(200);
    }*/
}

<?php

namespace Tests\Feature;

use Database\Factories\ChurchFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class RoutesTestChurch extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function testIndex(): void
    {
        $response = $this->get('/api/church');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testCreate():void
    {
        $churchFactory = new ChurchFactory();

        $data = $churchFactory->definition();

        $response = $this->post('/api/church/create', $data);

        $response->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('churchs', $data);

    }

    public function testCreateStatus422():void
    {
        $churchFactory = new ChurchFactory();

        $data = $churchFactory->definition();

        $data['name'] = '';

        $response = $this->post('/api/church/create', $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testEdit():void
    {
        $response = $this->get('/api/church/edit/1');

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdate():void
    {
        $churchFactory = new ChurchFactory();

        $data = $churchFactory->definition();

        $response = $this->put('/api/church/update/1', $data);

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('churchs', $data);
    }

    public function testUpdateStatus422():void
    {
        $churchFactory = new ChurchFactory();

        $data = $churchFactory->definition();

        $data['name'] = "";

        $response = $this->put('/api/church/update/1', $data);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

  /*  public function testDelete():void
    {
        $response = $this->delete('/api/church/delete/22');

        $response->assertStatus(200);
    }*/
}

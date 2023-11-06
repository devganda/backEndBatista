<?php

namespace Tests\Feature;

use Database\Factories\MemberFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    public function testIndexMember(): void
    {
        $response = $this->get('/api/members');

        $response->assertStatus(200);
    }

    public function testMemberCreate(): void
    {
        $memberFactory =  new MemberFactory();

        $data = $memberFactory->definition();

        $response = $this->post('/api/members/create', $data); 

        $response->assertStatus(201);

        $this->assertDatabaseHas('members', $data);
    }

    public function testEdit()
    {
        $response = $this->get('/api/members/edit/1');

        $response->assertStatus(200);
    }

    public function testEditStatus404()
    {
        $response = $this->get('/api/members/edit/10');
        
        $response->assertStatus(404);
    }

    public function testMemberCreateStatus422(): void
    {
        $memberFactory =  new MemberFactory();

        $data = $memberFactory->definition();

        $data['name'] = '';

        $response = $this->post('/api/members/create', $data); 

        $response->assertStatus(422);
    }

  public function testMemberUpdate():void
    {
        $memberFactory =  new MemberFactory();

        $data = $memberFactory->definition();

        $response = $this->put('/api/members/update/1', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('members', $data);
    }

    public function testMemberUpdateStatus422():void
    {
        $memberFactory =  new MemberFactory();

        $data = $memberFactory->definition();

        $data['name'] = '';

        $response = $this->put('/api/members/update/1', $data);

        $response->assertStatus(422);
    }

     /* public function testDeleteMember():void
    {
        $response = $this->delete('/api/members/delete/9');
        $response->assertStatus(200);
    }

    public function testDeleteMemberStatus404():void
    {
        $response = $this->delete('/api/members/delete/30');

        $response->assertStatus(404);
    } */
}

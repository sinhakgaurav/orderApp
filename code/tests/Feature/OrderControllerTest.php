<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class OrderControllerTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testOrders()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer EFA545D71E354EFBFA6CBE8BBAE9ED76'
        ])->json('GET', '/api/orders?page=0&limit=10');

        $response->assertStatus(200);
    }

    public function testStore()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer EFA545D71E354EFBFA6CBE8BBAE9ED76'
        ])->json('POST', '/api/order', [
            "origin" => [
                "28.704060",
                "77.102493"
            ],
            "destination" => [
                "28.535517",
                "77.391029"
            ]
        ]);

        $response->assertStatus(200);
    }

    public function testStoreMissingOriginRequest()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer EFA545D71E354EFBFA6CBE8BBAE9ED76'
        ])->json('POST', '/api/order', [
            "destination" => [
                "28.535517",
                "77.391029"
            ]
        ]);

        $response->assertStatus(500);
    }

    public function testStoreMissingDestinationRequest()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer EFA545D71E354EFBFA6CBE8BBAE9ED76'
        ])->json('POST', '/api/order', [
            "origin" => [
                "28.704060",
                "77.102493"
            ]
        ]);

        $response->assertStatus(500);
    }

    public function testUpdate()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer EFA545D71E354EFBFA6CBE8BBAE9ED76'
        ])->json('PUT', '/api/order/60', [
                "status" => "taken"
        ]);

        $response->assertStatus(200);
    }

    public function testUpdateMissingRequestBody()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer EFA545D71E354EFBFA6CBE8BBAE9ED76'
        ])->json('PUT', '/api/order/1', []);

        $response->assertStatus(500);
    }

    public function testUpdateInvalidId()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer EFA545D71E354EFBFA6CBE8BBAE9ED76'
        ])->json('PUT', '/api/order/101a', []);

        $response->assertStatus(500);
    }

    public function testUpdateOrderAlreadyTaken()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer EFA545D71E354EFBFA6CBE8BBAE9ED76'
        ])->json('PUT', '/api/order/1', [
                "status" => "taken"
        ]);

        $response->assertStatus(409);
    }

  /*  public function testDestory()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer EFA545D71E354EFBFA6CBE8BBAE9ED76'
        ])->json('DELETE', '/api/delete/50');

        $response->assertStatus(200);
    }*/
}

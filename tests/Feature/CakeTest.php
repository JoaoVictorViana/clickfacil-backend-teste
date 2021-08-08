<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CakeTest extends TestCase
{

    /**
     * A basic feature test create a cake.
     *
     * @return void
     */
    public function test_create_cake()
    {
        $data = [
            'name' => 'Teste de Bolo',
            'weight' => 300,
            'price' => 180.50,
            'quantity' => 10,
        ];

        $response = $this->post('/api/cake', $data);

        $response->assertStatus(201)
                    ->assertJson([
                        'data' => [
                            'cake_id' => 1,
                            'name' => 'Teste de Bolo',
                            'weight' => 300,
                            'price' => 180.5,
                            'quantity' => 10,
                            'emails' => []
                        ]
                    ]);
    }

    /**
     * A basic feature test read a cake.
     *
     * @return void
     */
    public function test_read_cake()
    {
        $response = $this->get('/api/cake');

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        [
                            'cake_id' => 1,
                            'name' => 'Teste de Bolo',
                            'weight' => 300,
                            'price' => 180.5,
                            'quantity' => 10,
                            'emails' => []
                        ]
                    ]
                ]);
    }

    /**
     * A basic feature test update a cake.
     *
     * @return void
     */
    public function test_update_cake()
    {
        $data = [
            'name' => 'Teste de Bolo Editado',
        ];

        $response = $this->put('/api/cake/1', $data);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Bolo atualizado com sucesso!'
                ]);
    }

    /**
     * A basic feature test remove a cake.
     *
     * @return void
     */
    public function test_delete_cake()
    {
        $response = $this->delete('/api/cake/1');

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Bolo deletado com sucesso!'
                ]);
    }

    /**
     * A basic feature test create cake with email list.
     *
     * @return void
     */
    public function test_create_cake_with_email()
    {
        $data = [
            'name' => 'Teste de Bolo',
            'weight' => 300,
            'price' => 180.50,
            'quantity' => 10,
            'list_emails' => [
                'teste@gmail.com'
            ]
        ];

        $response = $this->post('/api/cake', $data);

        $response->assertStatus(201)
                    ->assertJson([
                        'data' => [
                            'cake_id' => 2,
                            'name' => 'Teste de Bolo',
                            'weight' => 300,
                            'price' => 180.5,
                            'quantity' => 10,
                            'emails' => []
                        ]
                    ]);
    }

    /**
     * A basic feature test create cake without attribute.
     *
     * @return void
     */
    public function test_create_cake_validator()
    {
        $data = [
            'weight' => 300,
            'price' => 180.50,
            'quantity' => 10,
        ];

        $response = $this->post('/api/cake', $data);

        $response->assertStatus(500)
                    ->assertJson([
                        "name" => [
                            "The name field is required."
                        ],
                    ]);
    }

    /**
     * A basic feature test create a cake with 50k e-mails.
     *
     * @return void
     */
    public function test_stress()
    {
        $data = [
            'name' => 'Teste de Bolo',
            'weight' => 300,
            'price' => 180.50,
            'quantity' => 10,
            'list_emails' => array_fill(0, 50000, 'teste@gmail.com'),
        ];

        $response = $this->post('/api/cake', $data);

        $response->assertStatus(201)
                    ->assertJson([
                        'data' => [
                            'cake_id' => 3,
                            'name' => 'Teste de Bolo',
                            'weight' => 300,
                            'price' => 180.5,
                            'quantity' => 10,
                            'emails' => []
                        ],
                    ]);

    }
}

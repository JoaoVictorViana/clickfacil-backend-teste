<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmailCakeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_email()
    {
        $data_email = [
            'cake_id_fk' => 2,
            'email' => 'teste@gmail.com',
        ];

        $response = $this->post('/api/email', $data_email);

        $response->assertStatus(201)
                ->assertJson([
                    'data' => [
                        'email_interested_cake_id' => 1,
                        'cake_id_fk' => 2,
                        'email' => 'teste@gmail.com'
                    ]
                ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_read_email()
    {
        $response = $this->get('/api/email');

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        [
                            'email_interested_cake_id' => 1,
                            'cake_id_fk' => 2,
                            'email' => 'teste@gmail.com'
                        ]
                    ]
                ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update_email()
    {
        $data_email = [
            'email' => 'outro@gmail.com',
        ];

        $response = $this->put('/api/email/1', $data_email);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'E-mail atualizado com sucesso!'
                ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_delete_email()
    {
        $response = $this->delete('/api/email/1');

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'E-mail deletado com sucesso!'
                ]);
    }

    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_list_emails()
    {
        $data_emails = [
            'cake_id' => 1,
            'list_emails' => [
                'teste@gmail.com',
                'outro@gmail.com',
            ]
        ];

        $response = $this->post('/api/email/list', $data_emails);

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'E-mails cadastrados com sucesso!',
                ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_email_validator()
    {
        $data = [
            'cake_id_fk' => 1,
        ];

        $response = $this->post('/api/email', $data);

        $response->assertStatus(500)
                    ->assertJson([
                        "email" => [
                            "The email field is required."
                        ],
                    ]);
    }
}

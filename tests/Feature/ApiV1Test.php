<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiV1Test extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_get_calculating_without_params()
    {
        $response = $this->get('/api/v2/quote/rates/');

        $response->assertStatus(400);
    }

    public function test_get_calculating_with_one_params()
    {
        $response = $this->get('/api/v2/quote/rates/ESBCN');

        $response->assertStatus(400);
    }

    public function test_get_calculating_with_two_params_without_count()
    {
        $response = $this->get('/api/v2/quote/rates/ESBCN/USMIA1');

        $response
            ->assertStatus(400)
            ->assertJson([
                'message' => 'Bad request, enter the correct data. STATE1,STATE2,COUNT'
            ]);
    }

    public function test_get_calculating_with_all_params_but_wrong_port()
    {
        $response = $this->get('/api/v2/quote/rates/ESBCN/USMIA1/10');

        $response
            ->assertStatus(400)
            ->assertJson([
                'message' => 'One of the specified ports is not in service. Sorry',
            ]);
    }

    public function test_get_calculating_with_all_params_but_time_left_or_wrong_data()
    {
        $response = $this->get('/api/v2/quote/rates/ESBCN/ESMUS/10');

        $response
            ->assertStatus(404)
            ->assertJson([
                'message' => 'Nothing found',
            ]);
    }

    public function test_get_calculating_with_all_params_and_time_isset()
    {
        $response = $this->get('/api/v2/quote/rates/ESBCN/USMIA/10');

        $response->assertStatus(200);
    }

}

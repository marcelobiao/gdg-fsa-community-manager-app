<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * Configurando key de acesso da API
     *
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->getBearerToken(),
            'Accept' => 'application/json'
        ]);
    }

    protected function getBearerToken()
    {
        $response = $this->postJson('/api/register/', ['name' => 'Conexa', 'email' => 'marcelo@gmail.com', 'password' => '123456']);
        $responseData = json_decode($response->getContent(),true);
                
        return $responseData['access_token'];
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProductsApiReturn200()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;
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

    public function testProductsApiReturnsProduct()
    {
        $products = factory(\App\Product::class, 1)->create();
        $product = $products->jsonSerialize()[0];
       
        $response = $this->get(route('products.index'));
        $resultsJson = json_decode($response->content());
        $responseProducts = ($resultsJson->data);
        $responseProduct = $responseProducts[0];

        $this->assertEquals(1,count($responseProducts));
        $this->assertEquals($product['id'],$responseProduct->id);
        $this->assertEquals($product['name'],$responseProduct->name);
        $this->assertEquals($product['created_at'],$responseProduct->created_at);
        $this->assertEquals($product['updated_at'],$responseProduct->updated_at);
    }

    public function testProductsApiReturnsTwoProducts()
    {
        $products = factory(\App\Product::class, 2)->create()->jsonSerialize();
  
        $response = $this->get(route('products.index'));
        $resultsJson = json_decode($response->content());
        $responseProducts = ($resultsJson->data);
        
        $this->assertEquals(2,count($responseProducts));
        $this->assertEquals($products[0]['id'],($responseProducts[0])->id);
        $this->assertEquals($products[1]['id'],($responseProducts[1])->id);
    }

    public function testProductDescriptionApiReturnsDescriptionList()
    {
        $product = factory(\App\Product::class)->create();
        $product->descriptions()->saveMany(factory(\App\Description::class, 2)->make());
        $descriptions = $product->descriptions()->get();
  
        $response = $this->get(route('products.descriptions.index', ['products' => $product->id]));
        $resultsJson = json_decode($response->content());
        $responseProducts = ($resultsJson->data);
        
        $this->assertEquals($descriptions->first()->id,($responseProducts[0])->id);
        $this->assertEquals($descriptions->first()->product_id,($responseProducts[0])->product_id);
        $this->assertEquals($descriptions->first()->body,($responseProducts[0])->body);
        $this->assertEquals($descriptions->first()->created_at,($responseProducts[0])->created_at);
        $this->assertEquals($descriptions->first()->updated_at,($responseProducts[0])->updated_at);
        $this->assertEquals($descriptions->last()->id,($responseProducts[1])->id);
        $this->assertEquals($descriptions->last()->product_id,($responseProducts[1])->product_id);
        $this->assertEquals($descriptions->last()->body,($responseProducts[1])->body);
        $this->assertEquals($descriptions->last()->created_at,($responseProducts[1])->created_at);
        $this->assertEquals($descriptions->last()->updated_at,($responseProducts[1])->updated_at);
    }
}

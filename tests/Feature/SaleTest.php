<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sale;
use Carbon\Carbon;


/**
 * Class SaleTest
 *
 * @package Tests\Feature
 */
class SaleTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /**
     * Test the index endpoint.
     *
     * @return void
     */
    public function testIndex()
    {
        // Hit the index endpoint
        $response = $this->get('/api/v1/sales');

        // Ensure the response has a 200 status code
        $response->assertStatus(200);
    }

    /**
     * Test the store endpoint.
     *
     * @return void
     */
    public function testStore()
    {
        // Create fake data for the sale
        $saleData = [
            'status' => $this->faker->numberBetween(1, 3),
            'ref_num' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
            'invoice_date' => Carbon::now()->addDay()->format('Y-m-d'),
            'delivery_date' => Carbon::now()->addDay()->format('Y-m-d'),
            'payee' => $this->faker->name,
            'payee_id' => $this->faker->numberBetween(1, 100),
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'currency' => $this->faker->currencyCode,
            'currency_total' => $this->faker->randomFloat(2, 100, 1000),
            'paid' => $this->faker->randomFloat(2, 0, 100),
            'due' => $this->faker->randomFloat(2, 0, 100),
            'rounding' => $this->faker->randomFloat(2, 0, 10),
            'due_date' => Carbon::now()->addDay()->format('Y-m-d'),
            'attn' => $this->faker->text(200),
            'payment_term' => $this->faker->word,
            'payment_status' => $this->faker->numberBetween(0, 1),
            'delivery_status' => $this->faker->numberBetween(0, 1),
            'branch_id' => $this->faker->numberBetween(1, 10),
            'locked' => 1, //$this->faker->numberBetween(0, 1),
            'staff_id' => $this->faker->numberBetween(1, 20),
            'author_id' => $this->faker->numberBetween(1, 10),
        ];

        // Send a POST request to the store endpoint with the fake data
        $response = $this->post('/api/v1/sales', $saleData);

        // Assert that the response has a 201 status code (created)
        $response->assertStatus(201);
    }

    /**
     * Test the update endpoint.
     *
     * @return void
     */
    public function testUpdate()
    {
        $updatedSaleData = [
            'status' => $this->faker->numberBetween(1, 3),
            'ref_num' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
            'invoice_date' => Carbon::now()->addDay()->format('Y-m-d'),
            'delivery_date' => Carbon::now()->addDay()->format('Y-m-d'),
            'payee' => $this->faker->name,
            'payee_id' => $this->faker->numberBetween(1, 100),
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'currency' => $this->faker->currencyCode,
            'currency_total' => $this->faker->randomFloat(2, 100, 1000),
            'paid' => $this->faker->randomFloat(2, 0, 100),
            'due' => $this->faker->randomFloat(2, 0, 100),
            'rounding' => $this->faker->randomFloat(2, 0, 10),
            'due_date' => Carbon::now()->addDay()->format('Y-m-d'),
            'attn' => $this->faker->text(200),
            'payment_term' => $this->faker->word,
            'payment_status' => $this->faker->numberBetween(0, 1),
            'delivery_status' => $this->faker->numberBetween(0, 1),
            'branch_id' => $this->faker->numberBetween(1, 10),
            'locked' => 1,
            'staff_id' => $this->faker->numberBetween(1, 20),
            'author_id' => $this->faker->numberBetween(1, 10),
        ];

        $id = 22;

        // Send a PUT request to the update endpoint with the fake data
        $response = $this->put('/api/v1/sales/' . $id, $updatedSaleData);

        // Assert that the response has a 200 status code
        $response->assertStatus(200);
    }

    /**
     * Test the show endpoint.
     *
     * @return void
     */
    public function testShow()
    {
        $id = 21;
        // Hit the show endpoint for the specific sale ID
        $response = $this->get('/api/v1/sales/' . $id);

        // Ensure the response has a 200 status code
        $response->assertStatus(200);
    }

    /**
     * Test the force delete endpoint.
     *
     * @return void
     */
    public function testDelete()
    {
        $id = 1;
        // Hit the force delete endpoint
        $response = $this->delete('/api/v1/sales/' . $id);

        // Ensure the response has a 204 status code (No Content)
        $response->assertStatus(204);
    }

    /**
     * Test the bulk soft delete endpoint.
     *
     * @return void
     */
    public function testBulkSoftDelete()
    {
        $ids = [3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];

        // Hit the bulk soft delete endpoint
        $response = $this->delete('/api/v1/sales/bulk-soft-delete', ['ids' => $ids]);

        // Ensure the response has a 204 status code (No Content)
        $response->assertStatus(204);
    }

    /**
     * Test the force delete endpoint.
     *
     * @return void
     */
    public function testForceDelete()
    {
        $id = 1;
        // Hit the force delete endpoint
        $response = $this->delete('/api/v1/sales/force/' . $id);

        // Ensure the response has a 204 status code (No Content)
        $response->assertStatus(204);
    }

    /**
     * Test the bulk force delete endpoint.
     *
     * @return void
     */
    public function testBulkForceDelete()
    {
        $ids = [15, 16];

        // Hit the bulk force delete endpoint
        $response = $this->delete('/api/v1/sales/bulk-force-delete', ['ids' => $ids]);

        // Ensure the response has a 204 status code (No Content)
        $response->assertStatus(204);
    }

    /**
     * Test the recover endpoint.
     *
     * @return void
     */
    public function testRecover()
    {
        $id = 6;
        // Hit the recover endpoint
        $response = $this->patch('/api/v1/sales/recover/' . $id);

        // Ensure the response has a 204 status code (No Content)
        $response->assertStatus(200);
    }

    /**
     * Test the bulk recover endpoint.
     *
     * @return void
     */
    public function testBulkRecover()
    {
        $ids = [7, 8];

        // Hit the bulk recover endpoint
        $response = $this->patch('/api/v1/sales/bulk-recover', ['ids' => $ids]);

        // Ensure the response has a 204 status code (No Content)
        $response->assertStatus(204);
    }

    /**
     * Test the paginate endpoint.
     *
     * @return void
     */
    public function testPaginate()
    {
        // Hit the paginate endpoint
        $response = $this->get('/api/v1/sales/paginate');

        // Ensure the response has a 200 status code
        $response->assertStatus(200);
    }

    /**
     * Test the soft deleted endpoint.
     *
     * @return void
     */
    public function testSoftDelete()
    {
        // Hit the soft deleted endpoint
        $response = $this->get('/api/v1/sales/soft-deleted');

        // Ensure the response has a 200 status code
        $response->assertStatus(200);
    }

    /**
     * Test the total sales endpoint.
     *
     * @return void
     */
    public function testTotalSales()
    {
        // Hit the total sales endpoint
        $response = $this->get('/api/v1/sales/total-sales');

        // Ensure the response has a 200 status code
        $response->assertStatus(200);
    }

    /**
     * Test the filter endpoint.
     *
     * @return void
     */
    public function testFilter()
    {
        $columns = ['locked' => 0, 'status' => 1];

        // Hit the filter endpoint
        $response = $this->get('/api/v1/sales/filter', $columns);

        // Ensure the response has a 200 status code
        $response->assertStatus(200);
    }
}

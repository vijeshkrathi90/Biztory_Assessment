<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sale;
use Carbon\Carbon;

class SalePerformanceTest extends TestCase
{
    use WithFaker;

    /**
     * Test inserting 1000 sales records for performance.
     *
     * @return void
     */
    public function testCreateSales()
    {
        // Disable mass assignment protection for the test
        Sale::unguard();

        // Measure the time taken to insert 1000 sales records
        $startTime = microtime(true);

        // Loop to create and save 1000 Sale records
        for ($i = 0; $i < 1000; $i++) {
            Sale::create([
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
                'rounding' => 2,
                'due_date' => Carbon::now()->addDay()->format('Y-m-d'),
                'attn' => $this->faker->text(200),
                'payment_term' => $this->faker->word,
                'payment_status' => $this->faker->numberBetween(0, 1),
                'delivery_status' => $this->faker->numberBetween(0, 1),
                'branch_id' => $this->faker->numberBetween(1, 10),
                'locked' => 1, //$this->faker->numberBetween(0, 1),
                'staff_id' => $this->faker->numberBetween(1, 20),
                'author_id' => $this->faker->numberBetween(1, 10),
            ]);
        }

        // Calculate the elapsed time
        $elapsedTime = microtime(true) - $startTime;

        // Assert that the time taken is less than a certain threshold (adjust as needed)
        $this->assertLessThan(5, $elapsedTime, 'Inserting 1000 sales records took too long.');

        // Output the time taken
        dump("Time taken to insert 1000 sales records: {$elapsedTime} seconds");

        // Re-enable mass assignment protection
        Sale::reguard();
    }
}

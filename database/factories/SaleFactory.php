<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'status' => $this->faker->numberBetween(1, 3),
            'ref_num' => $this->faker->text(10),
            'invoice_date' => $this->faker->dateTimeBetween('2024-01-01', '2024-01-31')->format('Y-m-d'),
            'delivery_date' => $this->faker->dateTimeBetween('2024-01-01', '2024-01-31')->format('Y-m-d'),
            'payee' => $this->faker->name,
            'payee_id' => $this->faker->numberBetween(1, 10),
            'total' => $this->faker->randomFloat(2, 100, 1000),
            'currency' => $this->faker->currencyCode,
            'currency_total' => $this->faker->randomFloat(2, 100, 1000),
            'paid' => $this->faker->randomFloat(2, 0, 100),
            'due' => $this->faker->randomFloat(2, 0, 100),
            'rounding' => 1,
            'due_date' => $this->faker->dateTimeBetween('2024-01-01', '2024-01-31')->format('Y-m-d'),
            'attn' => $this->faker->text(200),
            'payment_term' => $this->faker->word,
            'payment_status' => $this->faker->numberBetween(0, 1),
            'delivery_status' => $this->faker->numberBetween(0, 1),
            'branch_id' => $this->faker->numberBetween(1, 10),
            'locked' => $this->faker->boolean,
            'staff_id' => $this->faker->numberBetween(1, 20),
            'author_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}

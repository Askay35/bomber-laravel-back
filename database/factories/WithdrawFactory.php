<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Withdraw;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Withdraw>
 */
class WithdrawFactory extends Factory
{

    protected $model = Withdraw::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            'user_id' => fake()->numberBetween(1,User::all()->count()),
            'status_id' => fake()->numberBetween(1,DB::table('deposite_statuses')->count()),
            'system_id' => fake()->numberBetween(1,DB::table('pay_systems')->count()),
            'size' => fake()->numberBetween(500,50000),
            'details' => fake()->numberBetween(1000,9999) . ' ' . fake()->numberBetween(1000,9999) . ' ' .  fake()->numberBetween(1000,9999) . ' ' . fake()->numberBetween(1000,9999),
            'created_at' => fake()->dateTimeBetween('-20 days', now()),
            'updated_at' => fake()->dateTimeBetween('-20 days', now()),

        ];
    }
}

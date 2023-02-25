<?php

namespace Database\Factories;

use App\Models\Deposite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deposite>
 */
class DepositeFactory extends Factory
{
    protected $model = Deposite::class;

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
            'created_at' => fake()->dateTimeBetween('-20 days', now()),
            'updated_at' => fake()->dateTimeBetween('-20 days', now()),
        ];
    }
}

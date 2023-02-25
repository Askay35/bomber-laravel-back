<?php

namespace Database\Factories;

use App\Models\Bet;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bet>
 */
class BetFactory extends Factory
{
    protected $model = Bet::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $betsize = fake()->numberBetween(10,100000);
        $coef = fake()->randomFloat(2, 1,30);
        $win = intval($betsize * $coef);

        return [
            'user_id' => fake()->numberBetween(1,User::all()->count()),
            'round_id' => fake()->numberBetween(1,DB::table('rounds')->count()),
            'bet_size' => $betsize,
            'coef' => $coef,
            'win' => $win,
            'date_time' => fake()->dateTimeBetween('-20 days', now()),
        ];
    }
}

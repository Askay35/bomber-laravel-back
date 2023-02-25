<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    protected $model = User::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $last_activity = fake()->dateTimeBetween('-20 days', now());

        return [
            'name' => fake()->name(),
            'email' => Str::random(10) . '@' . ['gmail.com','mail.ru','yandex.ru'][random_int(0, 2)],
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'token' => Str::random(60),
            'money' => fake()->numberBetween(0, 1000000),
            'last_activity' => $last_activity,
            'created_at' => fake()->dateTimeBetween('-20 days', now()),
            'updated_at' => $last_activity,
        ];
    }

//    /**
//     * Indicate that the model's email address should be unverified.
//     *
//     * @return static
//     */
//    public function unverified()
//    {
//        return $this->state(fn (array $attributes) => [
//            'email_verified_at' => null,
//        ]);
//    }
}

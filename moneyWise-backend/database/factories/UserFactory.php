<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
        /**
        * The name of the factory's corresponding model.
        *
        * @var string
        */
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'fullname' => $this->faker->name(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'budget' => $this->faker->randomFloat(2, 0, 10000),
        ];
    }
}

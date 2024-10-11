<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
       // Define a static array of possible prefixes
       $prefixes = ['Mr.', 'Ms.', 'Mrs.'];

       return [
           'prefixname' => $this->faker->randomElement($prefixes), // Randomly select a prefix
           'firstname' => $this->faker->firstName(),
          // 'middlename' => $this->faker->optional()->middleName(),
           'lastname' => $this->faker->lastName(),
           'suffixname' => $this->faker->optional()->suffix(),
           'username' => $this->faker->unique()->userName(),
           'email' => $this->faker->unique()->safeEmail(),
           'password' => Hash::make('password'), // Hashed password
           'photo' => $this->faker->optional()->imageUrl(), // Optional photo URL
           'type' => 'user', // Default type
       ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

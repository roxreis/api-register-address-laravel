<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'zip_code' => $this->faker->randomNumber(8),
            'house_number' => $this->faker->randomNumber(),
            'street' => $this->faker->streetAddress(),
            'complement' => $this->faker->sentence(2),
            'neighborhood' => $this->faker->sentence(),
            'city' => $this->faker->city(),
            'state' => $this->faker->countryISOAlpha3(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}

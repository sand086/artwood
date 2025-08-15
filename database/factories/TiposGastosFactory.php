<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TiposGastos;

class TiposGastosFactory extends Factory
{
    protected $model = TiposGastos::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->words(2, true),
            'prioridad' => $this->faker->numberBetween(1, 10),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Personas;
use App\Models\EstadosPaises;
use App\Models\Municipios;
use App\Models\TiposIdentificaciones;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personas>
 */
class PersonasFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Personas::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombres' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'direccion' => $this->faker->streetAddress,
            'telefono' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'estado_pais_id' => EstadosPaises::inRandomOrder()->first()->estado_pais_id,
            'municipio_id' => Municipios::inRandomOrder()->first()->municipio_id, // Idealmente, filtrar por estado_pais_id
            'tipo_identificacion_id' => TiposIdentificaciones::inRandomOrder()->first()->tipo_identificacion_id,
            'identificador' => $this->faker->unique()->numerify('########'), // Ajusta el formato si es necesario
            'estado' => $this->faker->randomElement(['A', 'I']),
        ];
    }
}

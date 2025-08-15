<?php

namespace Database\Factories;

use App\Models\Proveedores;
use App\Models\Colonias;
use App\Models\Municipios;
use App\Models\EstadosPaises;
use App\Models\Usuarios;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Proveedores>
 */
class ProveedoresFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proveedores::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'tipo' => $this->faker->randomElement(['EMPRESA', 'PERSONA']),
            'direccion' => $this->faker->streetAddress,
            'colonia_id' => Colonias::inRandomOrder()->first()?->colonia_id ?? null, // Asume que puede ser null si no hay colonias o si es opcional
            'municipio_id' => Municipios::inRandomOrder()->first()->municipio_id,
            'estado_pais_id' => EstadosPaises::inRandomOrder()->first()->estado_pais_id,
            'telefono' => $this->faker->numerify('##########'), // Genera 10 dígitos numéricos
            'sitio_web' => $this->faker->optional()->url,
            'notas_adicionales' => $this->faker->optional()->paragraph,
            'usuario_id' => Usuarios::inRandomOrder()->first()->usuario_id,
            'estado' => $this->faker->randomElement(['A', 'I']), // 'E' (Eliminado) usualmente no se genera por factory
            // 'fecha_registro' y 'fecha_actualizacion' son manejados por Eloquent/DB
        ];
    }
}

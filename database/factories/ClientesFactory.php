<?php

namespace Database\Factories;

use App\Models\Clientes;
use App\Models\TiposClientes;
use App\Models\Colonias;
use App\Models\Municipios;
use App\Models\EstadosPaises;
use App\Models\Usuarios;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clientes>
 */
class ClientesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Clientes::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company,
            'tipo_cliente_id' => TiposClientes::inRandomOrder()->first()->tipo_cliente_id, // O TiposClientes::inRandomOrder()->first()->tipo_cliente_id si ya tienes datos
            'clase' => $this->faker->randomElement(['CLIENTE', 'PROSPECTO']),
            'direccion' => $this->faker->streetAddress,
            'colonia_id' => null, // Puedes hacerlo opcional o usar Colonias::factory()
            // Para las siguientes, asegúrate de que los factories existan o haya datos en las tablas
            'municipio_id' => Municipios::inRandomOrder()->first()->municipio_id, // O Municipios::inRandomOrder()->first()->municipio_id
            'estado_pais_id' => EstadosPaises::inRandomOrder()->first()->estado_pais_id, // O EstadosPaises::inRandomOrder()->first()->estado_pais_id
            'telefono' => $this->faker->phoneNumber,
            'sitio_web' => $this->faker->optional()->url,
            'notas_adicionales' => $this->faker->optional()->paragraph,
            'usuario_id' => Usuarios::inRandomOrder()->first()->usuario_id, // O Usuarios::inRandomOrder()->first()->usuario_id
            'estado' => $this->faker->randomElement(['A', 'I']), // 'A' para Activo, 'I' para Inactivo
            // 'fecha_registro' y 'fecha_actualizacion' son manejados por Eloquent/DB
        ];
    }

    // Puedes agregar estados aquí si necesitas variaciones específicas
    // public function prospecto()
    // {
    //     return $this->state(fn (array $attributes) => ['clase' => 'PROSPECTO']);
    // }
}
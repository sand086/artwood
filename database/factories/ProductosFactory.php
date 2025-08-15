<?php

namespace Database\Factories;

use App\Models\Productos;
use App\Models\UnidadesMedidas; // Asegúrate de que este modelo exista y tenga datos o factory
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Productos>
 */
class ProductosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Productos::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productosConstruccion = [
            ['nombre' => 'Cemento Portland Gris', 'descripcion' => 'Saco de cemento gris de 50kg para uso general en construcción.'],
            ['nombre' => 'Ladrillo Común Macizo', 'descripcion' => 'Ladrillo cerámico macizo para mampostería.'],
            ['nombre' => 'Arena Fina de Revoque', 'descripcion' => 'Arena lavada fina para revoques y terminaciones.'],
            ['nombre' => 'Varilla de Acero Corrugado 10mm', 'descripcion' => 'Barra de acero corrugado para estructuras de hormigón.'],
            ['nombre' => 'Placa de Yeso Laminado (Durlock/Pladur)', 'descripcion' => 'Placa estándar de 12.5mm para tabiquería y cielorrasos.'],
            ['nombre' => 'Aislante Térmico de Lana de Vidrio', 'descripcion' => 'Rollo de aislante térmico y acústico de lana de vidrio.'],
            ['nombre' => 'Tubo PVC Sanitario 110mm', 'descripcion' => 'Tubo de PVC para desagües cloacales y pluviales.'],
            ['nombre' => 'Pintura Látex Interior Blanca', 'descripcion' => 'Lata de pintura látex para interiores, acabado mate.'],
            ['nombre' => 'Viga de Madera Laminada', 'descripcion' => 'Viga estructural de madera laminada encolada.'],
            ['nombre' => 'Malla Electrosoldada Q188', 'descripcion' => 'Panel de malla electrosoldada para refuerzo de losas y plateas.'],
        ];
        $productoSeleccionado = $this->faker->randomElement($productosConstruccion);

        return [
            'nombre' => $productoSeleccionado['nombre'],
            'descripcion' => $this->faker->optional(0.7, $productoSeleccionado['descripcion'])->sentence(10), // Descripción más genérica a veces
            'unidad_medida_id' => UnidadesMedidas::inRandomOrder()->first()->unidad_medida_id, // Asume que tienes UnidadesMedidas
            'precio_unitario' => $this->faker->randomFloat(2, 5, 500), // Precio entre 5.00 y 500.00
            'estado' => $this->faker->randomElement(['A', 'I']),
            // 'fecha_registro' y 'fecha_actualizacion' son manejados por Eloquent/DB
        ];
    }
}
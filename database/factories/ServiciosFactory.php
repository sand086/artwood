<?php

namespace Database\Factories;

use App\Models\Servicios;
use App\Models\UnidadesMedidas; // Asegúrate de que este modelo exista y tenga datos o factory
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 */
class ServiciosFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Servicios::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $serviciosConstruccion = [
            ['nombre' => 'Diseño Arquitectónico de Vivienda Unifamiliar', 'descripcion' => 'Elaboración de planos y diseño completo para vivienda.'],
            ['nombre' => 'Cálculo Estructural para Edificación', 'descripcion' => 'Análisis y diseño de la estructura portante del edificio.'],
            ['nombre' => 'Instalación Eléctrica Residencial', 'descripcion' => 'Servicio completo de instalación de sistema eléctrico.'],
            ['nombre' => 'Plomería y Sanitaria para Obra Nueva', 'descripcion' => 'Instalación de tuberías de agua potable y desagües.'],
            ['nombre' => 'Movimiento de Tierras y Excavación', 'descripcion' => 'Preparación del terreno, excavaciones para cimientos.'],
            ['nombre' => 'Colocación de Revestimientos Cerámicos', 'descripcion' => 'Instalación de pisos y paredes cerámicas o porcelanatos.'],
            ['nombre' => 'Pintura Interior y Exterior de Edificios', 'descripcion' => 'Aplicación de pintura en superficies interiores y fachadas.'],
            ['nombre' => 'Supervisión Técnica de Obra', 'descripcion' => 'Control y seguimiento de la ejecución de la obra según planos.'],
            ['nombre' => 'Consultoría en Eficiencia Energética', 'descripcion' => 'Asesoramiento para optimizar el consumo energético de la edificación.'],
            ['nombre' => 'Alquiler de Maquinaria Pesada (Retroexcavadora)', 'descripcion' => 'Servicio de alquiler de retroexcavadora con operador.'],
        ];
        $servicioSeleccionado = $this->faker->randomElement($serviciosConstruccion);

        return [
            //
            'nombre' => $servicioSeleccionado['nombre'],
            'descripcion' => $this->faker->optional(0.7, $servicioSeleccionado['descripcion'])->sentence(15),
            'tiempo' => $this->faker->numberBetween(1, 30), // Podría ser días, horas, semanas, dependiendo de la unidad
            'unidad_medida_id' => UnidadesMedidas::inRandomOrder()->first()->unidad_medida_id, // Asume que tienes UnidadesMedidas con datos
            'precio' => $this->faker->randomFloat(2, 50, 5000), // Precio del servicio
            'estado' => $this->faker->randomElement(['A', 'I']),
            // 'fecha_registro' y 'fecha_actualizacion' son manejados por Eloquent/DB
        ];
    }
}

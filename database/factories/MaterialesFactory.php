<?php

namespace Database\Factories;

use App\Models\Materiales;
use App\Models\UnidadesMedidas; // Asegúrate de que este modelo exista y tenga datos o factory
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materiales>
 */
class MaterialesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Materiales::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $materialesConstruccion = [
            ['nombre' => 'Cemento Portland Gris Bolsa 50kg', 'descripcion' => 'Cemento para uso general en construcción, alta resistencia.'],
            ['nombre' => 'Arena Fina Lavada', 'descripcion' => 'Arena para revoques, mezclas finas y contrapisos.'],
            ['nombre' => 'Piedra Partida (Grava)', 'descripcion' => 'Agregado grueso para hormigones y bases.'],
            ['nombre' => 'Ladrillo Común Macizo', 'descripcion' => 'Ladrillo cerámico para mampostería portante o de cerramiento.'],
            ['nombre' => 'Ladrillo Hueco Cerámico 12x18x33', 'descripcion' => 'Ladrillo cerámico alivianado para tabiques y cerramientos.'],
            ['nombre' => 'Bloque de Hormigón 19x19x39', 'descripcion' => 'Bloque para mampostería de rápida ejecución.'],
            ['nombre' => 'Varilla de Acero Corrugado Ø10mm', 'descripcion' => 'Barra de acero para armaduras en estructuras de hormigón.'],
            ['nombre' => 'Malla Electrosoldada Q188 (15x15cm Ø6mm)', 'descripcion' => 'Panel de acero para refuerzo de losas y plateas.'],
            ['nombre' => 'Cal Hidratada Bolsa 25kg', 'descripcion' => 'Cal para mezclas de albañilería, mejora trabajabilidad.'],
            ['nombre' => 'Placa de Yeso Laminado Estándar 12.5mm', 'descripcion' => 'Placa para tabiquería y cielorrasos en seco.'],
            ['nombre' => 'Perfil Montante Acero Galvanizado 70mm', 'descripcion' => 'Perfil estructural para sistemas de construcción en seco.'],
            ['nombre' => 'Perfil Solera Acero Galvanizado 70mm', 'descripcion' => 'Perfil guía para sistemas de construcción en seco.'],
            ['nombre' => 'Tornillo Autoperforante T1 Punta Aguja', 'descripcion' => 'Tornillo para fijación de placas de yeso a perfiles metálicos.'],
            ['nombre' => 'Cinta de Papel para Juntas', 'descripcion' => 'Cinta para tratamiento de juntas en placas de yeso.'],
            ['nombre' => 'Masilla para Juntas Lista Uso', 'descripcion' => 'Masilla para tomado de juntas en construcción en seco.'],
            ['nombre' => 'Aislante Lana de Vidrio Rollo 50mm', 'descripcion' => 'Aislante térmico y acústico para techos y tabiques.'],
            ['nombre' => 'Poliestireno Expandido (Telgopor) Plancha 20mm', 'descripcion' => 'Plancha de aislante térmico de alta densidad.'],
            ['nombre' => 'Membrana Asfáltica con Aluminio 4mm Rollo 10m²', 'descripcion' => 'Impermeabilizante para techos y cubiertas.'],
            ['nombre' => 'Pintura Asfáltica Base Solvente', 'descripcion' => 'Imprimación para membranas asfálticas.'],
            ['nombre' => 'Pintura Látex Interior Blanca Balde 20L', 'descripcion' => 'Pintura para paredes y cielorrasos interiores, acabado mate.'],
            ['nombre' => 'Enduido Plástico Interior Pote 1kg', 'descripcion' => 'Masilla para corregir imperfecciones en superficies interiores.'],
            ['nombre' => 'Fijador Sellador al Agua Concentrado 1L', 'descripcion' => 'Imprimación para mejorar adherencia de pinturas.'],
            ['nombre' => 'Adhesivo para Cerámicos Impermeable Bolsa 30kg', 'descripcion' => 'Pegamento para colocación de revestimientos cerámicos.'],
            ['nombre' => 'Pastina para Juntas Color Blanco Bolsa 1kg', 'descripcion' => 'Mortero para rellenar juntas entre cerámicos.'],
            ['nombre' => 'Cerámico Esmaltado Piso 30x30cm', 'descripcion' => 'Revestimiento cerámico para pisos de tránsito moderado.'],
            ['nombre' => 'Porcelanato Símil Madera 20x120cm', 'descripcion' => 'Revestimiento de alta resistencia y estética madera.'],
            ['nombre' => 'Tubo PVC Sanitario Ø110mm x 4m', 'descripcion' => 'Cañería para desagües cloacales y pluviales.'],
            ['nombre' => 'Codo PVC Sanitario Ø110mm a 90° HH', 'descripcion' => 'Accesorio para cambio de dirección en desagües.'],
            ['nombre' => 'Tubo Polipropileno Fusión Agua Fría/Caliente Ø20mm x 4m', 'descripcion' => 'Cañería para distribución de agua potable.'],
            ['nombre' => 'Codo Polipropileno Fusión Ø20mm a 90° HH', 'descripcion' => 'Accesorio para sistema de termofusión.'],
            ['nombre' => 'Cable Unipolar 2.5mm² Rollo 100m (Celeste)', 'descripcion' => 'Conductor eléctrico para instalaciones domiciliarias.'],
            ['nombre' => 'Caño Corrugado PVC Ignífugo Ø3/4" Rollo 25m', 'descripcion' => 'Cañería flexible para protección de cables eléctricos.'],
            ['nombre' => 'Caja Rectangular PVC para Embutir', 'descripcion' => 'Caja para mecanismos eléctricos en pared.'],
            ['nombre' => 'Interruptor Unipolar Tecla Simple', 'descripcion' => 'Mecanismo para control de iluminación.'],
            ['nombre' => 'Tomacorriente Bipolar Combinado 10A', 'descripcion' => 'Mecanismo para conexión de artefactos eléctricos.'],
            ['nombre' => 'Viga de Madera Pino Elliotis Cepillada 3"x6" x 3.05m', 'descripcion' => 'Madera estructural para techos y entramados.'],
            ['nombre' => 'Machimbre de Pino 1/2"x4" Calidad Comercial', 'descripcion' => 'Revestimiento de madera para cielorrasos o paredes.'],
            ['nombre' => 'Clavo Punta París 2.5"', 'descripcion' => 'Clavo de acero para carpintería y construcción.'],
            ['nombre' => 'Alambre de Atar Recocido N°16 Rollo 1kg', 'descripcion' => 'Alambre maleable para ataduras en armaduras.'],
            ['nombre' => 'Puerta Placa Pino Marco Chapa', 'descripcion' => 'Puerta interior económica para pintar.'],
            ['nombre' => 'Ventana Aluminio Blanco Corrediza Vidrio Entero 1.50x1.10m', 'descripcion' => 'Abertura estándar para viviendas.'],
            ['nombre' => 'Vidrio Float Incoloro 4mm', 'descripcion' => 'Vidrio común para ventanas y aberturas.'],
            ['nombre' => 'Silicona Acética Transparente Cartucho 280ml', 'descripcion' => 'Sellador para juntas y vidrios.'],
            ['nombre' => 'Hormigón Elaborado H21 Bombeable', 'descripcion' => 'Mezcla de hormigón lista para usar, calidad controlada.'],
            ['nombre' => 'Teja Cerámica Colonial Esmaltada', 'descripcion' => 'Teja para cubiertas inclinadas, acabado brillante.'],
            ['nombre' => 'Chapa Sinusoidal Galvanizada C25', 'descripcion' => 'Chapa acanalada para cubiertas y cerramientos.'],
            ['nombre' => 'Aislante de Espuma de Polietileno con Aluminio 10mm', 'descripcion' => 'Aislante térmico reflectivo para techos.'],
            ['nombre' => 'Canaleta de Chapa Galvanizada Desarrollo 30cm', 'descripcion' => 'Elemento para recolección de agua de lluvia en techos.'],
            ['nombre' => 'Rejilla de Desagüe Pluvial Hierro Fundido 20x20cm', 'descripcion' => 'Rejilla para bocas de desagüe en patios y veredas.'],
            ['nombre' => 'Tanque de Agua Tricapa Polietileno 1000L', 'descripcion' => 'Reserva de agua potable para viviendas.'],
            ['nombre' => 'Grifería Monocomando para Lavatorio Cromada', 'descripcion' => 'Grifería moderna para baños.'],
            ['nombre' => 'Inodoro Corto Loza Blanca con Depósito de Apoyar', 'descripcion' => 'Sanitario básico para baño.'],
            ['nombre' => 'Puerta de Chapa Inyectada con Poliuretano (Exterior)', 'descripcion' => 'Puerta de acceso principal con aislación.'],
            ['nombre' => 'Barniz Marino Brillante 1L', 'descripcion' => 'Protector para maderas expuestas a la intemperie.'],
            ['nombre' => 'Diluyente Aguarrás Mineral 1L', 'descripcion' => 'Solvente para pinturas sintéticas y limpieza.'],
        ];

        $materialSeleccionado = $this->faker->randomElement($materialesConstruccion);

        return [
            'nombre' => $materialSeleccionado['nombre'],
            'descripcion' => $this->faker->optional(0.3, $materialSeleccionado['descripcion'])->sentence(8), // A veces una descripción más genérica
            'unidad_medida_id' => UnidadesMedidas::inRandomOrder()->first()->unidad_medida_id,
            'precio_unitario' => $this->faker->randomFloat(2, 0.5, 1500), // Precio entre 0.50 y 1500.00
            'estado' => $this->faker->randomElement(['A', 'I']),
            // 'fecha_registro' y 'fecha_actualizacion' son manejados por Eloquent/DB
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Equipos;
use App\Models\UnidadesMedidas; // Asegúrate de que este modelo exista y tenga datos
use App\Models\Proveedores;   // Asegúrate de que este modelo exista y tenga datos
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipos>
 */
class EquiposFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Equipos::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $equiposConstruccion = [
            ['nombre' => 'Retroexcavadora', 'marca' => 'Caterpillar', 'modelo' => '420F2'],
            ['nombre' => 'Minicargadora', 'marca' => 'Bobcat', 'modelo' => 'S70'],
            ['nombre' => 'Excavadora sobre orugas', 'marca' => 'Komatsu', 'modelo' => 'PC200'],
            ['nombre' => 'Martillo Demoledor Eléctrico', 'marca' => 'Bosch', 'modelo' => 'GSH 11E'],
            ['nombre' => 'Compactadora de Placa (Bailarina)', 'marca' => 'Wacker Neuson', 'modelo' => 'VP1550'],
            ['nombre' => 'Hormigonera 1 Saco', 'marca' => 'Cipsa', 'modelo' => 'Maxi 10'],
            ['nombre' => 'Andamio Tubular Estándar', 'marca' => 'Layher', 'modelo' => 'Blitz'],
            ['nombre' => 'Generador Eléctrico 5500W', 'marca' => 'Honda', 'modelo' => 'EU7000is'],
            ['nombre' => 'Bomba de Agua Sumergible 2HP', 'marca' => 'Grundfos', 'modelo' => 'SP 3A-25'],
            ['nombre' => 'Sierra Circular 7 1/4"', 'marca' => 'DeWalt', 'modelo' => 'DWE575SB'],
            ['nombre' => 'Taladro Percutor Inalámbrico', 'marca' => 'Makita', 'modelo' => 'XPH12Z'],
            ['nombre' => 'Nivel Láser Autonivelante', 'marca' => 'Spectra', 'modelo' => 'LL300N'],
            ['nombre' => 'Camión Volquete 6m³', 'marca' => 'Ford', 'modelo' => 'F-600 Dump'],
            ['nombre' => 'Rodillo Compactador Vibratorio 1 Ton', 'marca' => 'Dynapac', 'modelo' => 'CC900'],
            ['nombre' => 'Cortadora de Pavimento 14"', 'marca' => 'Husqvarna', 'modelo' => 'FS400LV'],
            ['nombre' => 'Soldadora Inverter 200A', 'marca' => 'Lincoln Electric', 'modelo' => 'Invertec V155-S'],
            ['nombre' => 'Compresor de Aire 185 CFM', 'marca' => 'Sullair', 'modelo' => '185 Series'],
            ['nombre' => 'Pistola de Clavos Neumática', 'marca' => 'Paslode', 'modelo' => 'F350S'],
            ['nombre' => 'Vibrador de Concreto Eléctrico', 'marca' => 'Enar', 'modelo' => 'Dingo'],
            ['nombre' => 'Allanadora de Concreto (Helicóptero) 36"', 'marca' => 'Whiteman', 'modelo' => 'J36H55'],
            ['nombre' => 'Montacargas 2.5 Ton', 'marca' => 'Toyota', 'modelo' => '8FGCU25'],
            ['nombre' => 'Plataforma Elevadora Tijera 8m', 'marca' => 'JLG', 'modelo' => '1930ES'],
            ['nombre' => 'Torre de Iluminación Portátil', 'marca' => 'Generac', 'modelo' => 'MLT6SMD'],
            ['nombre' => 'Dumper Autocargable 1m³', 'marca' => 'Ausa', 'modelo' => 'D100AHA'],
            ['nombre' => 'Pulidora de Pisos Industrial', 'marca' => 'Klindex', 'modelo' => 'Levighetor Max'],
            ['nombre' => 'Hidrolavadora Alta Presión 3000 PSI', 'marca' => 'Kärcher', 'modelo' => 'HD 6/15 M'],
            ['nombre' => 'Cortadora de Cerámica Manual', 'marca' => 'Rubi', 'modelo' => 'TX-900-N'],
            ['nombre' => 'Estación Total Topográfica', 'marca' => 'Topcon', 'modelo' => 'GM-50'],
            ['nombre' => 'Bomba de Concreto Estacionaria', 'marca' => 'Putzmeister', 'modelo' => 'TK 40'],
            ['nombre' => 'Manipulador Telescópico (Telehandler)', 'marca' => 'Manitou', 'modelo' => 'MT 625'],
            ['nombre' => 'Zanjadora Peatonal', 'marca' => 'Ditch Witch', 'modelo' => 'C16X'],
            ['nombre' => 'Equipo de Pintura Airless', 'marca' => 'Graco', 'modelo' => 'Ultra Max II 490'],
            ['nombre' => 'Tronzadora de Metal 14"', 'marca' => 'Milwaukee', 'modelo' => '6177-20'],
            ['nombre' => 'Esmeriladora Angular 4 1/2"', 'marca' => 'Metabo', 'modelo' => 'W9-115'],
            ['nombre' => 'Apisonador Manual (Pisón)', 'marca' => 'Genérico', 'modelo' => 'Estándar'],
            ['nombre' => 'Carretilla Elevadora Manual (Transpaleta)', 'marca' => 'Crown', 'modelo' => 'PTH 50'],
            ['nombre' => 'Escalera Extensible Aluminio 24ft', 'marca' => 'Werner', 'modelo' => 'D1524-2'],
            ['nombre' => 'Ventilador Industrial de Piso', 'marca' => 'Master', 'modelo' => 'MAC-20F'],
            ['nombre' => 'Deshumidificador Industrial', 'marca' => 'DryAir', 'modelo' => '2000'],
            ['nombre' => 'Calefactor Industrial Portátil Diesel', 'marca' => 'Mr. Heater', 'modelo' => 'MH125KTR'],
            ['nombre' => 'Detector de Metales para Construcción', 'marca' => 'Zircon', 'modelo' => 'MetalliScanner m40'],
            ['nombre' => 'Medidor de Distancia Láser', 'marca' => 'Leica', 'modelo' => 'Disto D2'],
            ['nombre' => 'Cámara de Inspección de Tuberías', 'marca' => 'Ridgid', 'modelo' => 'SeeSnake MicroReel'],
            ['nombre' => 'Valla de Seguridad Naranja Rollo 50m', 'marca' => 'Genérico', 'modelo' => 'Malla Naranja'],
            ['nombre' => 'Señalización Vial (Conos, Barreras)', 'marca' => 'Genérico', 'modelo' => 'Kit Básico'],
            ['nombre' => 'Contenedor de Escombros 5m³', 'marca' => 'Genérico', 'modelo' => 'Estándar Abierto'],
            ['nombre' => 'Oficina Móvil de Obra 20ft', 'marca' => 'ModuVated', 'modelo' => 'SiteOffice20'],
            ['nombre' => 'Baño Químico Portátil Estándar', 'marca' => 'PolyJohn', 'modelo' => 'PJN3'],
            ['nombre' => 'Cortadora de Bloques de Hormigón', 'marca' => 'IMER', 'modelo' => 'Masonry 350'],
            ['nombre' => 'Regla Vibratoria para Concreto', 'marca' => 'Marshalltown', 'modelo' => 'ScreeDemon'],
            ['nombre' => 'Equipo de Sandblasting Portátil', 'marca' => 'Clemco', 'modelo' => 'Classic Blast Machine 1028'],
            ['nombre' => 'Grúa Pluma Pequeña para Camioneta', 'marca' => 'Vestil', 'modelo' => 'WTJ-4'],
        ];

        $equipoSeleccionado = $this->faker->randomElement($equiposConstruccion);

        return [
            'nombre' => $equipoSeleccionado['nombre'],
            'descripcion' => $this->faker->sentence(10),
            // 'marca' => $this->faker->optional(0.8, $equipoSeleccionado['marca'])->company(),
            // 'modelo' => $this->faker->optional(0.7, $equipoSeleccionado['modelo'])->bothify('??-####'),
            // 'numero_serie' => $this->faker->unique()->bothify('SN-#######???'),
            // 'costo_adquisicion' => $this->faker->randomFloat(2, 500, 50000),
            // 'fecha_adquisicion' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'unidad_medida_id' => UnidadesMedidas::inRandomOrder()->first()->unidad_medida_id, // Para la tarifa de uso (ej. Hora, Día)
            'precio_unitario' => $this->faker->randomFloat(2, 50, 10000),
            // 'tarifa_uso_por_unidad' => $this->faker->randomFloat(2, 10, 500), // Tarifa por hora, día, etc.
            // 'proveedor_id' => Proveedores::inRandomOrder()->first()?->proveedor_id, // Puede ser nulo si no se compró a un proveedor específico
            // 'estado_operativo' => $this->faker->randomElement(['OPERATIVO', 'MANTENIMIENTO', 'AVERIADO', 'FUERA_DE_SERVICIO']), // Asume un enum o varchar
            'estado' => $this->faker->randomElement(['A', 'I']),
            // 'fecha_registro' y 'fecha_actualizacion' son manejados por Eloquent/DB
        ];
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Asegúrate que esté importado

class UnidadesMedidasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Definir categorías (los valores DEBEN coincidir con el ENUM de la migración)
        define('CAT_MASA', 'MASA');
        define('CAT_VOLUMEN', 'VOLUMEN');
        define('CAT_LONGITUD', 'LONGITUD');
        define('CAT_CANTIDAD', 'CANTIDAD');
        define('CAT_SUPERFICIE', 'SUPERFICIE');
        define('CAT_TIEMPO', 'TIEMPO');

        $unidades = [
            // Masa
            ['nombre' => 'Kilogramo', 'simbolo' => 'kg', 'categoria' => CAT_MASA],
            ['nombre' => 'Gramo', 'simbolo' => 'g', 'categoria' => CAT_MASA],
            ['nombre' => 'Miligramo', 'simbolo' => 'mg', 'categoria' => CAT_MASA],
            ['nombre' => 'Libra', 'simbolo' => 'lb', 'categoria' => CAT_MASA],
            ['nombre' => 'Onza', 'simbolo' => 'oz', 'categoria' => CAT_MASA],

            // Volumen
            ['nombre' => 'Litro', 'simbolo' => 'l', 'categoria' => CAT_VOLUMEN],
            ['nombre' => 'Mililitro', 'simbolo' => 'ml', 'categoria' => CAT_VOLUMEN],
            ['nombre' => 'Galón', 'simbolo' => 'gal', 'categoria' => CAT_VOLUMEN],
            ['nombre' => 'Barril', 'simbolo' => 'brl', 'categoria' => CAT_VOLUMEN],
            ['nombre' => 'Metro cúbico', 'simbolo' => 'm3', 'categoria' => CAT_VOLUMEN],
            ['nombre' => 'Centímetro cúbico', 'simbolo' => 'cm3', 'categoria' => CAT_VOLUMEN],
            ['nombre' => 'Milímetro cúbico', 'simbolo' => 'mm3', 'categoria' => CAT_VOLUMEN],

            // Longitud
            ['nombre' => 'Metro', 'simbolo' => 'm', 'categoria' => CAT_LONGITUD],
            ['nombre' => 'Centímetro', 'simbolo' => 'cm', 'categoria' => CAT_LONGITUD],
            ['nombre' => 'Kilómetro', 'simbolo' => 'km', 'categoria' => CAT_LONGITUD],
            ['nombre' => 'Pulgada', 'simbolo' => 'in', 'categoria' => CAT_LONGITUD],

            // Cantidad / Conteo
            ['nombre' => 'Unidad', 'simbolo' => 'unid', 'categoria' => CAT_CANTIDAD],
            ['nombre' => 'Pieza', 'simbolo' => 'pza', 'categoria' => CAT_CANTIDAD],
            ['nombre' => 'Caja', 'simbolo' => 'caja', 'categoria' => CAT_CANTIDAD],
            ['nombre' => 'Paquete', 'simbolo' => 'paq', 'categoria' => CAT_CANTIDAD],
            ['nombre' => 'Juego', 'simbolo' => 'jgo', 'categoria' => CAT_CANTIDAD],
            ['nombre' => 'Docena', 'simbolo' => 'doc', 'categoria' => CAT_CANTIDAD],
            ['nombre' => 'Saco', 'simbolo' => 'saco', 'categoria' => CAT_CANTIDAD], // O Masa, según contexto
            ['nombre' => 'Bulto', 'simbolo' => 'bult', 'categoria' => CAT_CANTIDAD], // O Masa, según contexto

            // Superficie / Área
            ['nombre' => 'Metro cuadrado', 'simbolo' => 'm²', 'categoria' => CAT_SUPERFICIE],
            ['nombre' => 'Centímetro cuadrado', 'simbolo' => 'cm²', 'categoria' => CAT_SUPERFICIE],
            ['nombre' => 'Kilómetro cuadrado', 'simbolo' => 'km²', 'categoria' => CAT_SUPERFICIE],
            ['nombre' => 'Hectárea', 'simbolo' => 'ha', 'categoria' => CAT_SUPERFICIE],
            ['nombre' => 'Pie cuadrado', 'simbolo' => 'ft²', 'categoria' => CAT_SUPERFICIE],
            ['nombre' => 'Yarda cuadrada', 'simbolo' => 'yd²', 'categoria' => CAT_SUPERFICIE],
            ['nombre' => 'Acre', 'simbolo' => 'ac', 'categoria' => CAT_SUPERFICIE],

            // Tiempo
            ['nombre' => 'Segundo', 'simbolo' => 's', 'categoria' => CAT_TIEMPO],
            ['nombre' => 'Minuto', 'simbolo' => 'min', 'categoria' => CAT_TIEMPO],
            ['nombre' => 'Hora', 'simbolo' => 'h', 'categoria' => CAT_TIEMPO],
            ['nombre' => 'Día', 'simbolo' => 'día', 'categoria' => CAT_TIEMPO],
            ['nombre' => 'Mes', 'simbolo' => 'mes', 'categoria' => CAT_TIEMPO],
            ['nombre' => 'Año', 'simbolo' => 'año', 'categoria' => CAT_TIEMPO],
        ];

        // Limpiar la tabla antes de insertar
        DB::table('unidadesmedidas')->delete(); // Opcional

        foreach ($unidades as $unidad) {
            DB::table('unidadesmedidas')->insert([
                'nombre' => $unidad['nombre'],
                'simbolo' => $unidad['simbolo'],
                'categoria' => $unidad['categoria'], // Insertar el valor de la categoría
                'estado' => 'A',
                'fecha_registro' => now(),
            ]);
        }
    }
}

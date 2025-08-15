<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            ['nombre' => 'Gerencia', 'descripcion' => 'Área de gerencia, encargada de la administracion de la empresa', 'estado' => 'I'],
            ['nombre' => 'Comercial', 'descripcion' => 'Área comercial, encargada de la gestión comercial de los productos y servicios de la empresa', 'estado' => 'A'],
            ['nombre' => 'Productos e instalaciones', 'descripcion' => 'Área de productos e instalaciones, encargada de la gestión de los productos e instalaciones', 'estado' => 'I'],
            ['nombre' => 'Obras y Matenimiento', 'descripcion' => 'Área de obras y mantenimiento, encargada de la gestión de obras y mantenimiento', 'estado' => 'I'],
            ['nombre' => 'Diseño moviliario', 'descripcion' => 'Área de diseño moviliario, encargada del diseño de los moviliarios', 'estado' => 'I'],
            ['nombre' => 'Licitaciones', 'descripcion' => 'Área de licitaciones, encargada de la gestión de licitaciones', 'estado' => 'I'],
            ['nombre' => 'Mobiliario', 'descripcion' => 'Área de mobiliario, encargada de la gestión de los mobiliarios', 'estado' => 'I'],
            ['nombre' => 'Compras', 'descripcion' => 'Área de compras, encargada de la gestión de las compras', 'estado' => 'I'],
            ['nombre' => 'Administración y Finanzas', 'descripcion' => 'Área administrativa, encargada de la gestión administrativa de la empresa', 'estado' => 'A'],
            ['nombre' => 'Produccion', 'descripcion' => 'Área de produccion, encargada de la produccion de productos', 'estado' => 'I'],
            ['nombre' => 'Financiera', 'descripcion' => 'Área financiera, encargada de la administracion de los recursos financieros', 'estado' => 'I'],
            ['nombre' => 'Operación', 'descripcion' => 'Área operativa, encargada de la produccion y entrega de productos', 'estado' => 'A'],
            ['nombre' => 'Recursos Humanos', 'descripcion' => 'Área de recursos humanos, encargada de la gestión del personal', 'estado' => 'I'],
            ['nombre' => 'Tecnologia', 'descripcion' => 'Área de tecnologia, encargada del soporte tecnico y desarrollo de software', 'estado' => 'I'],
            ['nombre' => 'Logistica', 'descripcion' => 'Área logistica, encargada del transporte y almacenamiento de productos', 'estado' => 'I'],
            ['nombre' => 'Atencion al Cliente', 'descripcion' => 'Área de atencion al cliente, encargada de la atencion y soporte a los clientes', 'estado' => 'I'],
            ['nombre' => 'Marketing', 'descripcion' => 'Área de marketing, encargada de la promocion y publicidad de productos', 'estado' => 'I'],
            ['nombre' => 'Calidad', 'descripcion' => 'Área de calidad, encargada de la gestión de la calidad de los productos', 'estado' => 'I'],
            ['nombre' => 'Legal', 'descripcion' => 'Área legal, encargada de la gestión legal y normativa', 'estado' => 'I'],
            ['nombre' => 'Contabilidad', 'descripcion' => 'Área contable, encargada de la gestión contable y tributaria', 'estado' => 'I'],
            ['nombre' => 'Auditoria', 'descripcion' => 'Área auditoria, encargada de la auditoria interna y externa', 'estado' => 'I'],
        ];

        foreach ($areas as $area) {
            DB::table('areas')->insert([
                'nombre' => $area['nombre'],
                'descripcion' => $area['descripcion'],
                'estado' => $area['estado'],
                'fecha_registro' => now(),
            ]);
        }
    }
}

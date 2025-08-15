<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = [
            ['nombre' => 'GRUPO DIAGNOSTICO ARIES', 'tipo_cliente_id' => 2, 'clase' => 'CLIENTE', 'rfc' => '', 'direccion' => 'Aviación Civil 35', 'colonia' => 'Industrial Puerto Aéreo', 'codigo_postal' => '15710', 'municipio_id' => 849, 'estado_pais_id' => 17, 'telefono' => ''],
            
            ['nombre' => 'ATIDTOV', 'tipo_cliente_id' => 2, 'clase' => 'CLIENTE', 'rfc' => 'ATI230721A63',  'direccion' => 'VITO ALESSIO ROBLES 51  INT. 202, ', 'colonia' => 'COL. EXHACIENDA DE GUADALUPE CHIMALISTAC', 'codigo_postal' => '1050','municipio_id' => 835, 'estado_pais_id' => 17, 'telefono' => ''],
            
            ['nombre' => 'AT&T COMUNICACIONES DIGITALES', 'tipo_cliente_id' => 2, 'clase' => 'CLIENTE', 'rfc' => 'CNM980114PI2',  'direccion' => '', 'colonia' => '', 'codigo_postal' => '6500', 'municipio_id' => null, 'estado_pais_id' => null, 'telefono' => ''],
            
            ['nombre' => 'GRUPO ZORRO ABARROTERO', 'tipo_cliente_id' => 2, 'clase' => 'CLIENTE', 'rfc' => 'GZA9104307K6',  'direccion' => 'AV CENTENARIO  2188 ', 'colonia' => 'COL. NUEVA ATZACOALCO', 'codigo_postal' => '07420', 'municipio_id' => 841, 'estado_pais_id' => 17, 'telefono' => ''],
            
            ['nombre' => 'INGENIERIA Y ASESORIA TECNICA INTEGRAL', 'tipo_cliente_id' => 2, 'clase' => 'CLIENTE', 'rfc' => 'IAT060418TG4',  'direccion' => 'TIHUATLAN  8  LOCALIDAD MEXICO', 'colonia' => 'SAN JERONIMO ACULCO', 'codigo_postal' => '10400', 'municipio_id' => 844, 'estado_pais_id' => 17, 'telefono' => ''],
            
            ['nombre' => 'SERVICIO DE ADMINISTRACION TRIBUTARIA', 'tipo_cliente_id' => 3, 'clase' => 'CLIENTE', 'rfc' => 'SAT970701NN3',  'direccion' => 'AV. HIDALGO 77', 'colonia' => 'COL. GUERRERO', 'codigo_postal' => ' 06300', 'municipio_id' => 840, 'estado_pais_id' => 17, 'telefono' => ''],
            
            ['nombre' => 'TCUATRO SERPROF', 'tipo_cliente_id' => 2, 'clase' => 'CLIENTE', 'rfc' => 'TSE2108193A8',  'direccion' => 'AVENIDA INSURGENTES SUR 1425  INT. PISO 4,', 'colonia' => 'COL. INSURGENTES MIXCOAC', 'codigo_postal' => '03920', 'municipio_id' => 837, 'estado_pais_id' => 17, 'telefono' => ''],
        ];

        foreach ($clientes as $cliente) {
            DB::table('clientes')->insert([
                'nombre' => $cliente['nombre'],
                'tipo_cliente_id' => $cliente['tipo_cliente_id'],
                'clase' => $cliente['clase'],
                'rfc' => $cliente['rfc'] ?? 'PENDIENTE',
                'direccion' => $cliente['direccion'] ?? 'INFORMACION PENDIENTE',
                'colonia' => $cliente['colonia'],
                'codigo_postal' => $cliente['codigo_postal'],
                'municipio_id' => $cliente['municipio_id'],
                'estado_pais_id' => $cliente['estado_pais_id'],
                'telefono' => $cliente['telefono'] ?? 'PENDIENTE',
                'usuario_id' => $cliente['usuario_id'] ?? 1,
                'estado' => 'A',
                'fecha_registro' => now(),
            ]);
        }
    }
}

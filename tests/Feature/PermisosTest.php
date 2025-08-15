<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Permission;

class PermisosTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_listar_permisos()
    {
        // Crear permisos de ejemplo
        Permission::create(['nombre' => 'ver usuarios', 'guard_name' => 'web']);
        Permission::create(['nombre' => 'crear usuarios', 'guard_name' => 'web']);

        // Realizar la petición a la ruta de permisos
        $response = $this->get('/permisos');

        $response->assertStatus(200);
        $response->assertSee('ver usuarios');
        $response->assertSee('crear usuarios');
    }

    /** @test */
    public function puede_crear_un_permiso()
    {
        $data = [
            'nombre' => 'nuevo permiso',
        ];

        $response = $this->post('/permisos', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('permisos', ['nombre' => 'nuevo permiso']);
    }
}

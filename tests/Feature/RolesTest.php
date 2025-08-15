<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Spatie\Permission\Models\Role;

class RolesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function puede_listar_roles()
    {
        // Crear roles de ejemplo
        Role::create(['nombre' => 'Administrador', 'guard_name' => 'web']);
        Role::create(['nombre' => 'Operativo', 'guard_name' => 'web']);

        // Realizar la petición a la ruta de roles
        $response = $this->get('/roles');

        $response->assertStatus(200);
        $response->assertSee('Administrador');
        $response->assertSee('Operativo');
    }

    /** @test */
    public function puede_crear_un_rol()
    {
        $data = [
            'nombre' => 'NuevoRol',
            // Agrega otros campos si es necesario
        ];

        $response = $this->post('/roles', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('roles', ['nombre' => 'NuevoRol']);
    }
}

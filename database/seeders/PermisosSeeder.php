<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permisos;
use App\Models\Roles;

class PermisosSeeder extends Seeder
{
    public function run()
    {
        // 1. Definir módulos y acciones
        $modules = [
            'usuarios',
            'clientes',
            'estadospaises',
            'municipios',
            'paises',
            'productos',
            'proveedores',
            'servicios',
            'roles',
            'permisos',
            'tipossolicitudes',
            'tiposgastos',
            'personas',
            'unidadesmedidas',
            'plazoscreditos'
        ];

        $actions = ['ver', 'crear', 'editar', 'eliminar'];

        // 2. Crear (o buscar) todos los permisos y organizarlos
        $allPermissions = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permName = "$action $module";
                $perm = Permisos::firstOrCreate([
                    'name'       => $permName,
                    'guard_name' => 'api' // Usar 'api' para JWT
                ]);
                $allPermissions[$module][$action] = $perm->name;
            }
        }

        // 3. Definir los permisos permitidos para cada rol
        $rolesPermissions = [
            'Master' => [
                'usuarios'         => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'clientes'         => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'estadospaises'    => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'municipios'       => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'paises'           => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'productos'        => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'proveedores'      => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'servicios'        => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'roles'            => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'permisos'         => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'tipossolicitudes' => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'tiposgastos'      => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'personas'         => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'unidadesmedidas'  => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
                'plazoscreditos'   => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => true],
            ],
            'Administrador' => [
                'usuarios'         => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'clientes'         => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'estadospaises'    => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'municipios'       => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'paises'           => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'productos'        => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'proveedores'      => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'servicios'        => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'roles'            => ['ver' => true,  'crear' => false, 'editar' => false, 'eliminar' => false],
                'permisos'         => ['ver' => true,  'crear' => false, 'editar' => false, 'eliminar' => false],
                'tipossolicitudes' => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'tiposgastos'      => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'personas'         => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'unidadesmedidas'  => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
                'plazoscreditos'   => ['ver' => true,  'crear' => true,  'editar' => true,  'eliminar' => false],
            ],
            'Operativo' => [
                'usuarios'         => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'clientes'         => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'estadospaises'    => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'municipios'       => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'paises'           => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'productos'        => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'proveedores'      => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'servicios'        => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'roles'            => ['ver' => false, 'crear' => false, 'editar' => false, 'eliminar' => false],
                'permisos'         => ['ver' => false, 'crear' => false, 'editar' => false, 'eliminar' => false],
                'tipossolicitudes' => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'tiposgastos'      => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'personas'         => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'unidadesmedidas'  => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => false],
                'plazoscreditos'   => ['ver' => true,  'crear' => true,  'editar' => false, 'eliminar' => true],
            ],
        ];

        // 4. Crear roles si no existen
        $master = Roles::firstOrCreate(['name' => 'Master', 'guard_name' => 'api']);
        $administrador = Roles::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'api']);
        $operativo = Roles::firstOrCreate(['name' => 'Operativo', 'guard_name' => 'api']);

        // 5. Asignar permisos a cada rol según la configuración
        foreach ($rolesPermissions as $roleName => $modulesPerms) {
            $syncPermissions = [];
            foreach ($modulesPerms as $module => $actionsAllowed) {
                foreach ($actionsAllowed as $action => $allowed) {
                    if ($allowed) {
                        $syncPermissions[] = $allPermissions[$module][$action];
                    }
                }
            }

            switch (strtolower($roleName)) {
                case 'master':
                    $master->syncPermissions($syncPermissions);
                    break;
                case 'administrador':
                    $administrador->syncPermissions($syncPermissions);
                    break;
                case 'operativo':
                    $operativo->syncPermissions($syncPermissions);
                    break;
            }
        }

        // 6. (Opcional) Asignar roles a usuarios existentes (si es necesario)
        // Ejemplo: Asignar rol "Operativo" a todos los usuarios que no tengan rol asignado
        $users = \App\Models\Usuarios::all();
        foreach ($users as $user) {
            if ($user->getRoleNames()->isEmpty()) {
                $user->assignRole('Master');
            }
        }
    }
}

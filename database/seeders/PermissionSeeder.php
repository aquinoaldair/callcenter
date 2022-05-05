<?php

namespace Database\Seeders;

use App\Repositories\Permission\PermissionRepository;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private $permission;

    public function __construct(PermissionRepository $permission)
    {
        $this->permission = $permission;
    }

    public function run()
    {
        $options = [
            [
                'name' => 'user',
                'title' => 'Usuarios',
            ],
            [
                'name' => 'role',
                'title' => 'Roles',
            ],
            [
                'name' => 'script',
                'title' => 'Scripts',
            ],
        ];


        $permissions = [
            [
                "name" => "create",
                "title" => "Crear"
            ],
            [
                "name" => "edit",
                "title" => "Editar"
            ],
            [
                "name" => "show",
                "title" => "Mostrar"
            ],
            [
                "name" => "delete",
                "title" => "Eliminar"
            ]
        ];

        foreach ($options as $option){
            foreach ($permissions as $permission){
                $ability = [
                    'name' => $permission["name"]."-".$option["name"],
                    'title' => $permission["title"]." ".$option["title"],
                ];

                $this->permission->create($ability);
            }
        }


    }
}

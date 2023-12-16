<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class AddMenusBase extends Seeder
{
    private const TABLE='menus_sistema';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(self::TABLE)->insert([
            [
                'publicId'=>'756141376788',
                'nombre'=>'ADD_USUARIOS',
                'display'=>'Adm. Usuarios',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/usuarios'
            ],
            [
                'publicId'=>'a1d359c738dc',
                'nombre'=>'UPDATE_USUARIO',
                'display'=>'Actualizar Usuario',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>2,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/usuario/actualizar'
            ],
            [
                'publicId'=>'17cb4433c3cc',
                'nombre'=>'ADD_ROLES',
                'display'=>'Adm. Roles de Usuario',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/roles'
            ],
            [
                'publicId'=>'a358fe31e7e2',
                'nombre'=>'ADD_ACCIONES_ROLES',
                'display'=>'Adm. Acciones de Roles',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>2,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/role/acciones'
            ],
            [
                'publicId'=>'ff04d9567d5b',
                'nombre'=>'ADD_CATEGORIAS',
                'display'=>'Adm. Categorias de Productos',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/catalogos/categorias'
            ],
            [
                'publicId'=>'a5bd2097a5bd',
                'nombre'=>'ADD_SUB_CATEGORIAS',
                'display'=>'Adm. Sub-Categorias de Productos',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>2,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/catalogos/categorias'
            ],
            [
                'publicId'=>'ad3e885c1b9b',
                'nombre'=>'ADD_ATRIBUTOS',
                'display'=>'Adm. Atributos de Productos',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/catalogos/atributos'
            ],
            [
                'publicId'=>'7ce8b63f66a8',
                'nombre'=>'ADD_MARCAS',
                'display'=>'Adm. Marca de Productos',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/catalogos/marcas'
            ],
            [
                'publicId'=>'4231ce3e55d2',
                'nombre'=>'ADD_PROVEEDORES',
                'display'=>'Adm. Proveedores',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/proveedores'
            ],
            [
                'publicId'=>'4231ce3e55d2',
                'nombre'=>'ADD_COSTOS',
                'display'=>'Adm. Costos',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/costos'
            ],
            [
                'publicId'=>'82a41b54e51c',
                'nombre'=>'ADD_ORGANIZACIONES',
                'display'=>'Adm. Organizaciones',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/organizaciones'
            ],
            [
                'publicId'=>'df7d9cc6f109',
                'nombre'=>'ADD_LISTAPRECIOS',
                'display'=>'Adm. Lista de Precios',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/listaspprecios'
            ],
            [
                'publicId'=>'bf37968482e0',
                'nombre'=>'ADD_LISTAPRECIOS_PRODUCTOS',
                'display'=>'Adm. Precios',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>2,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/listaspprecios/productos'
            ],
            [
                'publicId'=>'efd8f17c30df',
                'nombre'=>'ADD_CANALESVENTA',
                'display'=>'Adm. Canales de Venta',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>1,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/canalesventa'
            ],
            [
                'publicId'=>'3e757552333b',
                'nombre'=>'ADD_CANALESVENTA_LISTAPRECIOS',
                'display'=>'Asignacion Precios a Canales de Venta',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>2,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/canalesventa/listaprecios'
            ],
            [
                'publicId'=>'4c314173b0c9',
                'nombre'=>'ADD_SISTEMA_ROL_MODULOS',
                'display'=>'Adm. Modulos a Roles',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>3,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/sistema/modulos/roles'
            ],
            [
                'publicId'=>'792952bbfba6',
                'nombre'=>'ADD_PRODUCTOS',
                'display'=>'Adm. Productos',
                'essubmenu'=>false,
                'activo'=>true,
                'orden'=>3,
                'created_at'=>new DateTime(),
                'accion'=>'/admin/productos'
            ]
        ]);
    }
}

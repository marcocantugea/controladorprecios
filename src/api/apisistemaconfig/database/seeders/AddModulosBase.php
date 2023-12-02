<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddModulosBase extends Seeder
{
    private const TABLE='modulos_sistema';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(self::TABLE)->insert([
            [
                'publicId'=>'d18cb9d2d5fe',
                'nombre'=>'USUARIOS',
                'display'=>'Usuarios',
                'activo'=>true,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'47b9e012a701',
                'nombre'=>'SISTEMA',
                'display'=>'Sistema',
                'activo'=>true,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'5fef0313802b',
                'nombre'=>'PRODUCTOS',
                'display'=>'Productos',
                'activo'=>true,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'23a1d1f73498',
                'nombre'=>'COSTOS',
                'display'=>'Costos',
                'activo'=>true,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'ab07cde61999',
                'nombre'=>'ORGANIZACIONES',
                'display'=>'Organizaciones',
                'activo'=>true,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'122dbe87331c',
                'nombre'=>'PRECIOS',
                'display'=>'Precios',
                'activo'=>true,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'ca254594201a',
                'nombre'=>'CANALESVENTA',
                'display'=>'Canales de Venta',
                'activo'=>true,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'e3e6643852fc',
                'nombre'=>'CATALOGOS',
                'display'=>'Catalogos',
                'activo'=>true,
                'created_at'=>new DateTime()
            ]
        ]);
    }
}

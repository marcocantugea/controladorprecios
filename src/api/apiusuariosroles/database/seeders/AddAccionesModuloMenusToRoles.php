<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddAccionesModuloMenusToRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection()->table('acciones_sistema')->insert([
            ['publicId'=>'48eb58ff0f48',
                'accion'=>'ADD_MODULOS',
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ],
            ['publicId'=>'88b808c587f1',
                'accion'=>'UPDATE_MODULOS',
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ],
            ['publicId'=>'4599272c4fb0',
                'accion'=>'DELETE_MODULOS',
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ],
            ['publicId'=>'425218cd-1719',
                'accion'=>'READ_MODULOS',
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ],
            ['publicId'=>'0c314ebf8890',
                'accion'=>'ADD_MENUS',
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ],
            ['publicId'=>'e3770dd9e4fb',
                'accion'=>'UPDATE_MENUS',
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ],
            ['publicId'=>'ff83e9c2ecf5',
                'accion'=>'DELETE_MENUS',
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ],
            ['publicId'=>'5df6d0705800',
                'accion'=>'READ_MENUS',
                'activo'=>true,
                'created_at'=>new DateTime('now')
            ]
        ]);
    }
}

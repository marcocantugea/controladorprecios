<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddRolesSistema extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection()->table('roles_sistema')->insert(
            ['publicId'=>'6563f02152497',
            'rol'=>'ADMIN',
            'ACTIVO'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>uniqid(),
            'rol'=>'SUPER_USER',
            'ACTIVO'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>uniqid(),
            'rol'=>'READER',
            'ACTIVO'=>true,
            'created_at'=>new DateTime('now')
        ]
                
        );
    }
}

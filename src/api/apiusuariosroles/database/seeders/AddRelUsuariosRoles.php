<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddRelUsuariosRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usuario_rol')->insert([
            [
                'publicId'=>uniqid(),
                'usuarioId'=>1,
                'rolId'=>1,
                'usuarioPid'=>'95765b2da765',
                'rolPid'=>'65628f44d73b6',
                'created_at'=>new DateTime()
            ]
            ]);
    }
}

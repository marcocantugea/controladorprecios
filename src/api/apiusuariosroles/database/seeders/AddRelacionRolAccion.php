<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddRelacionRolAccion extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles_acciones_sistema')->insert([
            [
                'publicId'=>'02652b7fbb61',
                'rolId'=>1,
                'rolPid'=>'6563f02152497',
                'accionId'=>1,
                'accionPid'=>'cd5970ce2d63',
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'93d77ac8201a',
                'rolId'=>1,
                'rolPid'=>'6563f02152497',
                'accionId'=>2,
                'accionPid'=>'48b5f6de2688',
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'93d77ac8201a',
                'rolId'=>1,
                'rolPid'=>'6563f02152497',
                'accionId'=>3,
                'accionPid'=>'c458855e008c',
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>'4029617f2e3d',
                'rolId'=>1,
                'rolPid'=>'6563f02152497',
                'accionId'=>4,
                'accionPid'=>'8ab586153b3f',
                'created_at'=>new DateTime()
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddRolModulos extends Seeder
{
    private const TABLE='roles_modulos';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(self::TABLE)->insert([
            [
                'publicId'=>uniqid(),
                'rolPid'=>'6563f02152497',
                'moduloPid'=>'d18cb9d2d5fe',
                'moduloId'=>1,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'rolPid'=>'6563f02152497',
                'moduloPid'=>'47b9e012a701',
                'moduloId'=>2,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'rolPid'=>'6563f02152497',
                'moduloPid'=>'5fef0313802b',
                'moduloId'=>3,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'rolPid'=>'6563f02152497',
                'moduloPid'=>'23a1d1f73498',
                'moduloId'=>4,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'rolPid'=>'6563f02152497',
                'moduloPid'=>'ab07cde61999',
                'moduloId'=>5,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'rolPid'=>'6563f02152497',
                'moduloPid'=>'ca254594201a',
                'moduloId'=>7,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'rolPid'=>'6563f02152497',
                'moduloPid'=>'e3e6643852fc',
                'moduloId'=>8,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'rolPid'=>'6563f02152497',
                'moduloPid'=>'e3e6643852fc',
                'moduloId'=>8,
                'created_at'=>new DateTime()
            ]
        ]);
    }
}

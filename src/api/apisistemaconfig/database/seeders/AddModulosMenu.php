<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddModulosMenu extends Seeder
{
    private const TABLE='modulos_menus_sistema';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table(self::TABLE)->insert([
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'d18cb9d2d5fe',
                'menuPid'=>'756141376788',
                'moduloId'=>1,
                'menuId'=>1,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'d18cb9d2d5fe',
                'menuPid'=>'a1d359c738dc',
                'moduloId'=>1,
                'menuId'=>2,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'d18cb9d2d5fe',
                'menuPid'=>'17cb4433c3cc',
                'moduloId'=>1,
                'menuId'=>3,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'d18cb9d2d5fe',
                'menuPid'=>'a358fe31e7e2',
                'moduloId'=>1,
                'menuId'=>4,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'47b9e012a701',
                'menuPid'=>'6a96674dd2aa',
                'moduloId'=>2,
                'menuId'=>16,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'47b9e012a701',
                'menuPid'=>'4c314173b0c9',
                'moduloId'=>2,
                'menuId'=>16,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'5fef0313802b',
                'menuPid'=>'792952bbfba6',
                'moduloId'=>3,
                'menuId'=>17,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'23a1d1f73498',
                'menuPid'=>'4231ce3e55d2',
                'moduloId'=>4,
                'menuId'=>10,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'ab07cde61999',
                'menuPid'=>'82a41b54e51c',
                'moduloId'=>5,
                'menuId'=>11,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'122dbe87331c',
                'menuPid'=>'df7d9cc6f109',
                'moduloId'=>6,
                'menuId'=>12,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'122dbe87331c',
                'menuPid'=>'bf37968482e0',
                'moduloId'=>6,
                'menuId'=>13,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'ca254594201a',
                'menuPid'=>'efd8f17c30df',
                'moduloId'=>7,
                'menuId'=>14,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'ca254594201a',
                'menuPid'=>'3e757552333b',
                'moduloId'=>7,
                'menuId'=>15,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'e3e6643852fc',
                'menuPid'=>'ff04d9567d5b',
                'moduloId'=>8,
                'menuId'=>5,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'e3e6643852fc',
                'menuPid'=>'a5bd2097a5bd',
                'moduloId'=>8,
                'menuId'=>6,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'e3e6643852fc',
                'menuPid'=>'ad3e885c1b9b',
                'moduloId'=>8,
                'menuId'=>7,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'e3e6643852fc',
                'menuPid'=>'7ce8b63f66a8',
                'moduloId'=>8,
                'menuId'=>8,
                'created_at'=>new DateTime()
            ],
            [
                'publicId'=>uniqid(),
                'moduloPid'=>'e3e6643852fc',
                'menuPid'=>'4231ce3e55d2',
                'moduloId'=>8,
                'menuId'=>9,
                'created_at'=>new DateTime()
            ],
        ]);
    }
}

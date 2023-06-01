<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosDefaults extends Seeder{

    public function run(): void{
        DB::connection('users')->table('usuarios')->insert(
            ['publicId'=>uniqid(),
            'user'=>'admin',
            'hash'=>password_hash('macarena',PASSWORD_DEFAULT),
            'active'=>true,
            'created_at'=>new DateTime('now'),
            'email'=>'email@server.com'
            ],
            ['publicId'=>uniqid(),
            'user'=>'superuser',
            'hash'=>password_hash('superuser',PASSWORD_DEFAULT),
            'active'=>true,
            'created_at'=>new DateTime('now'),
            'email'=>'email@server.com'
            ]
        );
    }

}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class AddBaseUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('users')->table('usuarios')->insert(
            ['publicId'=>'95765b2da765',
            'user'=>'admin',
            'hash'=>password_hash('macarena',PASSWORD_DEFAULT),
            'active'=>true,
            'created_at'=>new DateTime('now'),
            'email'=>'email@server.com'
            ],
            ['publicId'=>'e59eb791ceca',
            'user'=>'superuser',
            'hash'=>password_hash('superuser',PASSWORD_DEFAULT),
            'active'=>true,
            'created_at'=>new DateTime('now'),
            'email'=>'email@server.com'
            ]
        );
    }
}

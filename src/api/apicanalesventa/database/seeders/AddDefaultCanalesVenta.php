<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddDefaultCanalesVenta extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('canalesventa')->insert([
            'publicId'=>'22c1fa7ef7b7',
            'nombre'=>'MercadoLibre Ecomerce',
            'codigo'=>'MLECO',
            'activo'=>true,
            'created_at'=>new DateTime()
        ]);

        DB::table('canalesventa')->insert([
            'publicId'=>'cf76f3b08e96',
            'nombre'=>'Amazon Ecomerce',
            'codigo'=>'AMECO',
            'activo'=>true,
            'created_at'=>new DateTime()
        ]);

        DB::table('canalesventa')->insert([
            'publicId'=>'c618d865dae4',
            'nombre'=>'Shopify Ecomerce',
            'codigo'=>'SHOECO',
            'activo'=>true,
            'created_at'=>new DateTime()
        ]);

        DB::table('canalesventa')->insert([
            'publicId'=>'4e636457451a',
            'nombre'=>'Web Site',
            'codigo'=>'WEBSITE',
            'activo'=>true,
            'created_at'=>new DateTime()
        ]);
    }
}

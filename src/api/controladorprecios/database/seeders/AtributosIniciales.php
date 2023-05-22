<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtributosIniciales extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('atributos')->insert([
            ['atributo'=>'Color','publicId'=>'45a8b8c0','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Alto','publicId'=>'45a8bb04','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Ancho','publicId'=>'45a8bc94','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Largo','publicId'=>'45a8c018','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Talla','publicId'=>'45a8c2a2','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Peso','publicId'=>'45a8c3ce','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Cantidad','publicId'=>'45a8cdf6','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Capacidad','publicId'=>'45a8c4e6','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Procesadores','publicId'=>'45a8c5ea','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Profundidad','publicId'=>'45a8c702','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Linea','publicId'=>'45a8c9d2','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Grado de viscosidad','publicId'=>'45a8caf4','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Durabilidad','publicId'=>'45a8cc52','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Volaje Max','publicId'=>'63c14138','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Volaje Min','publicId'=>'63c145ca','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
            ['atributo'=>'Marca','publicId'=>'cbd443e0','esSubatributo'=>false,'created_at'=>new \DateTime('now')],
        ]);
    }
}

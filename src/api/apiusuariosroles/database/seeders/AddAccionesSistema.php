<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddAccionesSistema extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection()->table('acciones_sistema')->insert([
        ['publicId'=>'cd5970ce2d63',
            'accion'=>'ADD',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'48b5f6de2688',
            'accion'=>'UPDATE',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'c458855e008c',
            'accion'=>'READ',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'39d7d02b3d1c',
            'accion'=>'ADD_PRODUCTOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'9c6b6cbf6208',
            'accion'=>'ADD_EQUIVALENCIA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'47e71ea5d4f4',
            'accion'=>'ADD_ORGANIZACION',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'30d1937ce7ab',
            'accion'=>'ADD_CATEGORIA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'de4aef87846c',
            'accion'=>'ADD_ATRIBUTO',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'6a4e47c09679',
            'accion'=>'ADD_MARCA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'69f41a99319c',
            'accion'=>'ADD_MARCA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'ea9ac14dd113',
            'accion'=>'ADD_USUARIOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'cee5ac609240',
            'accion'=>'ADD_PROVEEDOR',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'789f502b8ff2',
            'accion'=>'ADD_COSTOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'978a3c1c0959',
            'accion'=>'ADD_LISTAPRECIOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'a9bc11cb5c5b',
            'accion'=>'ADD_CANALVENTA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'7cce56c06f38',
            'accion'=>'UPDATE_PRODUCTOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'2d88afcd26b4',
            'accion'=>'UPDATE_EQUIVALENCIA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'37a3a6c8d246',
            'accion'=>'UPDATE_ORGANIZACION',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'9b21d3d6991d',
            'accion'=>'UPDATE_CATEGORIA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'f9d98c77ea62',
            'accion'=>'UPDATE_ATRIBUTO',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'2eeb25fc0ba9',
            'accion'=>'UPDATE_MARCA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'82f62adf5d14',
            'accion'=>'UPDATE_MARCA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'2bd6984cab4f',
            'accion'=>'UPDATE_USUARIOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'4d2ea1d821d3',
            'accion'=>'UPDATE_PROVEEDOR',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'6a2cf6980e2b',
            'accion'=>'UPDATE_COSTOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'a349cf439d42',
            'accion'=>'UPDATE_LISTAPRECIOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'b219c3972155',
            'accion'=>'UPDATE_CANALVENTA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'0026f7d71d02',
            'accion'=>'DELETE_PRODUCTOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'42f383d1e41f',
            'accion'=>'DELETE_EQUIVALENCIA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'cb26d4556b7d',
            'accion'=>'DELETE_ORGANIZACION',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'64a28f16074d',
            'accion'=>'DELETE_CATEGORIA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'8595b97c7b99',
            'accion'=>'DELETE_ATRIBUTO',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'f78e94017bf1',
            'accion'=>'DELETE_MARCA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'fb99f4838951',
            'accion'=>'DELETE_MARCA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'b3c5e0a26fae',
            'accion'=>'DELETE_USUARIOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'4d1a46846dfb',
            'accion'=>'DELETE_PROVEEDOR',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'c1bdf546824a',
            'accion'=>'DELETE_COSTOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'6c428bd64a13',
            'accion'=>'DELETE_LISTAPRECIOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'ef4c614e461d',
            'accion'=>'DELETE_CANALVENTA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'f30eb67a2b95',
            'accion'=>'READ_PRODUCTOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'545ea7a5d41a',
            'accion'=>'READ_EQUIVALENCIA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'93673b767955',
            'accion'=>'READ_ORGANIZACION',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'901d59a1a2d8',
            'accion'=>'READ_CATEGORIA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'236f0a063428',
            'accion'=>'READ_ATRIBUTO',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'a67af8729261',
            'accion'=>'READ_MARCA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'e4d0c2bd7d47',
            'accion'=>'READ_MARCA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'b2a89220f23f',
            'accion'=>'READ_USUARIOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'f4e113c64ce7',
            'accion'=>'READ_PROVEEDOR',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'263fd696707e',
            'accion'=>'READ_COSTOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'1b88e673e125',
            'accion'=>'READ_LISTAPRECIOS',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ],
        ['publicId'=>'fb2f6674c788',
            'accion'=>'READ_CANALVENTA',
            'activo'=>true,
            'created_at'=>new DateTime('now')
        ]
        ]);
    }
}

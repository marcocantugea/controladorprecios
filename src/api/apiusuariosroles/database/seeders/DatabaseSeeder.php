<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AddBaseUsers::class);
        $this->call(AddRolesSistema::class);
        $this->call(AddAccionesSistema::class);
        $this->call(AddRelacionRolAccion::class);
        $this->call(AddRelUsuariosRoles::class);
        $this->call(AddAccionesModuloMenusToRoles::class);
    }
}

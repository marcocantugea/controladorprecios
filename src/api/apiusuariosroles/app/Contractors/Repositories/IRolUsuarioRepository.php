<?php

namespace App\Contractors\Repositories;

interface IRolUsuarioRepository extends IRepository
{
    public function getRolByUserId(string $usuarioPid);
}

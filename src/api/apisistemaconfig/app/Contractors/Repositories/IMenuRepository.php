<?php

namespace App\Contractors\Repositories;

interface IMenuRepository extends IRepository {

    public function getMenus();
    public function getMenusByModulo(string $moduloPid);
    public function getMenuYModulosPorUsuario();
}
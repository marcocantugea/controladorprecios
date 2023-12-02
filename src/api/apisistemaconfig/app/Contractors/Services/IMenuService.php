<?php

namespace App\Contractors\Services;

use App\DTOs\MenuDTO;

interface IMenuService {

    function addMenu(MenuDTO $dto);
    function updateMenu(MenuDTO $menu);
    function deleteMenu(string $pid);
    function getMenuById(string $pid);
    function getMenus();
    function getMenusByModulo(string $moduloId);
    function getMenuYModulosPorUsuario();

}

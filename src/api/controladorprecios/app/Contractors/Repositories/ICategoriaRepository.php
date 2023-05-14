<?php

namespace App\Contractors\Repositories;
use App\Contractors\Data\IRepository;

interface ICategoriaRepository extends IRepository{

    function searchCategory(string $nombre);

}
<?php 

namespace App\Contractors\Repositories;

interface IRepository {

    function add($model);
    function update($model);
    function delete($id);
    function getById($id);
}


<?php 

namespace App\Contractors\Data;

interface IRepository {

    function add($model);
    function update($model);
    function delete($id);
    function getById($id);
}


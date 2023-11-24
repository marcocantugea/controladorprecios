<?php

namespace App\Contractors\Repositories;

interface IRepository{

    function add($model);
    function update($model);
    function getById($pid);
    function delete($pid);
}
<?php

namespace App\Contractors\Services;

Interface IAtributosService{

    function addAtributo($atributoDto);
    function updateAtributo($atributoDto);
    function deleteAtributo($id);
    function getAtributo($id);
    function getAtributos(array $serachParams);

}
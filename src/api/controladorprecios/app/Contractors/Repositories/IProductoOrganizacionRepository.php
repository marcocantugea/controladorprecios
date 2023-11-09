<?php 

namespace App\Contractors\Repositories;

interface IProductoOrganizacionRepository {

    function addOrganizacion(int $productoId,string $organizacionId);
    function deleteOrganizacion($publicId);
    function getOrganizaciones(int $productoId);

}
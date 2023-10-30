<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class OrganizacionController extends Controller
{
    public function addOrganizacion(){
        return new Response($this->stdResponse());
    }
}

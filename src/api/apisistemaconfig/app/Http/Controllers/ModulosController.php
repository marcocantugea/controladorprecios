<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

final class ModulosController extends Controller
{
    public function getModulos(){
        return new Response($this->stdResponse());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

final class UploaderContoller extends Controller
{
    public function show(){
        return new Response('done');
    }
}

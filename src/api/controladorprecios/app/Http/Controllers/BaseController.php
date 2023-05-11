<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    protected function stdResponse($success=true,$error=false,$message="",$data=null){
        return ["success"=>$success,"error"=>$error,"message"=>$message,"data"=>$data];
    }
}

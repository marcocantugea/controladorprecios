<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function stdResponse($success=true,$error=false,$message="",$data=null){
        return ["success"=>$success,"error"=>$error,"message"=>$message,"data"=>$data];
    }

    protected function validateJsonContent(Request $request){
        $jsonParsed=json_decode($request->getContent());
        if(empty($jsonParsed)) return new Response($this->stdResponse(false,true,"no valid content"),400);
        return $jsonParsed;
    }
}

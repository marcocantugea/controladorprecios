<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    protected function stdResponse($success=true,$error=false,$message="",$data=null){
        return ["success"=>$success,"error"=>$error,"message"=>$message,"data"=>$data];
    }

    protected function validateJsonContent(Request $request){
        $jsonParsed=json_decode($request->getContent());
        if(empty($jsonParsed)) return new Response($this->stdResponse(false,true,"no valid content"),400);
        return $jsonParsed;
    }

    public function HasAccionsPermit(array $actions) : bool {
        $userAccions=$_SESSION['actions'];
        $matches=array_intersect($userAccions,$actions);
        if(count($matches)<=0) return false;
        return true;
    }
}

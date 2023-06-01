<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\ServicesContainer;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AuthController extends BaseController{

    private AuthService $authService;

    public function __construct() {
        $this->authService= ServicesContainer::getService(AuthService::class);
    }

    public function AuthUsuario(Request $request){
        try {
            $jsonParsed= json_decode($request->getContent());
            if(!isset($jsonParsed->user) || !isset($jsonParsed->password)) 
                return new Response($this->stdResponse(false,true,"no user or pasword data found"),400);

            $this->authService->AuthenticatedUser($jsonParsed->user,$jsonParsed->password);
            $token=['token'=>base64_encode($jsonParsed->user.":".$jsonParsed->password)];
            return new Response($this->stdResponse(data:$token));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),400);
        }
    }

}
<?php

namespace App\Http\Controllers;

use App\Contractors\Services\IAuthService;
use App\Services\AuthService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AuthController extends Controller{

    private AuthService $authService;

    public function __construct(IAuthService $authService) {
        $this->authService= $authService;
    }

    public function AuthUsuario(Request $request){
        try {
            $jsonParsed= json_decode($request->getContent());
            if(!isset($jsonParsed->user) || !isset($jsonParsed->password)) 
                return new Response($this->stdResponse(false,true,"no user or pasword data found"),400);

            $user=$this->authService->AuthenticatedUser($jsonParsed->user,$jsonParsed->password);
            $token=['pid'=>$user->publicId,'token'=>base64_encode($jsonParsed->user.":".$jsonParsed->password),'actions'=>$user->actions];
            return new Response($this->stdResponse(data:$token));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),400);
        }
    }

}
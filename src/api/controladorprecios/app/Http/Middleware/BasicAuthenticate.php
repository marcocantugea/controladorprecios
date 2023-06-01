<?php

namespace App\Http\Middleware;

use App\Factories\AuthServiceFactory;
use Closure;
use Illuminate\Http\Request;

class BasicAuthenticate
{
 
     /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $authorizationHeader=$request->header('Authorization');
        if(!str_contains($authorizationHeader,"Basic"))  return response('Unauthorized.', 401);
        $token=str_replace("Basic ","",$authorizationHeader);
        $parseAuth=base64_decode($token);
        $credentials=explode(":",$parseAuth);
        try {
            $service=AuthServiceFactory::get();
            $service->AuthenticatedUser($credentials[0],$credentials[1]);
        } catch (\Throwable $th) {
            return response('Unauthorized.', 401);
        }
        
        return $next($request);
    }
    
}

<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IUsuariosService;
use App\Mappers\UsuarioMapper;
use App\Services\ServicesContainer;
use App\Services\UsuariosService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UsuarioController extends Controller{

    private IUsuariosService $service;
    private IMapper $mapper;

    public function __construct(IUsuariosService $usuarioService, UsuarioMapper $mapper) {
        $this->service= $usuarioService;
        $this->mapper=$mapper;
    }

    public function addUsuario(Request $request){
        try {
            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $dto->password=$jsonParsed->password;
            $this->service->addUsuario($dto);
            return new Response($this->stdResponse()); 
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function activateUsuario($id){
        try {
            $this->service->activateUsuario($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteUsuario($id){
        try {
            $this->service->deleteUsuario($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getUsuarios(Request $request){
        try {
            $searchParams= $request->query();
            $productosSearchParams=[];
            $limit=500;
            $offset=0;
            foreach ($searchParams as $key => $value) {
                if($key=='offset') {
                    $offset=$value;
                    continue;
                }

                if($key=='limit'){
                    $limit=$value;
                    continue;
                }

                $productosSearchParams+=[$key=>[$value,null]];
            }
            $usuariosFound=$this->service->getUsuarios($searchParams,$limit,$offset);
            return new Response($this->stdResponse(data:$usuariosFound));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

}
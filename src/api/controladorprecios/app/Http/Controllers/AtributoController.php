<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IAtributosService;
use App\Mappers\AtributoMapper;
use App\Services\AtributosService;
use App\Services\ServicesContainer;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class AtributoController extends BaseController
{
    private IAtributosService $service;
    private IMapper $mapper;

    public function __construct() {
        $this->service= ServicesContainer::getService(AtributosService::class);
        $this->mapper= ServicesContainer::getService(AtributoMapper::class);
    }

    public function addAtributo(Request $request){
        try {
            $atributoDto=json_decode($request->getContent());
            if(empty($atributoDto)) return new Response($this->stdResponse(false,true,"Invalid request content",null),400);
            $this->service->addAtributo($this->mapper->reverse($atributoDto));
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateAtributo(Request $request,$id){
        try {
            $atributoDto=json_decode($request->getContent());
            $atributoDto->publicId=$id;
            if(empty($atributoDto)) return new Response($this->stdResponse(false,true,"Invalid request content",null),400);
            $this->service->updateAtributo($this->mapper->reverse($atributoDto));
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteAtributo($id){
        try {
            $this->service->deleteAtributo($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getAtributo($id){
        try {
            $atributo=$this->service->getAtributo($id);
            $dto=$this->mapper->reverse($atributo);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getAtributos(Request $request){
        try {
            $searchParams = $request->query();
            $validSearchParams = [
                'atributo',
                'activo',
                'publicId',
                'esSubatributo'
            ];
            $queryParams = [];
            foreach ($searchParams as $key => $value) {
                if (!in_array($key, $validSearchParams)) continue;
                $queryParams+=[$key => $value];
            }

            $items=$this->service->getAtributos($queryParams);
            return new Response($this->stdResponse(data:$items));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }

    }

}
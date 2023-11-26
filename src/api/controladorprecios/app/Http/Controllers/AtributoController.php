<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IAtributosService;
use App\Enums\AccionsEnums;
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

    public function __construct(IAtributosService $atributoService, AtributoMapper $mapper) {
        $this->service= $atributoService;
        $this->mapper= $mapper;
    }

    public function addAtributo(Request $request){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_ATRIBUTO_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

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

            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_ATRIBUTO_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

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
            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_ATRIBUTO_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $this->service->deleteAtributo($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getAtributo($id){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ATRIBUTO_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $atributo=$this->service->getAtributo($id);
            $dto=$this->mapper->reverse($atributo);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getAtributos(Request $request){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_ATRIBUTO_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            
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
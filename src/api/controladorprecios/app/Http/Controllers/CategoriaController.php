<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\ICategoriaService;
use App\Enums\AccionsEnums;
use App\Mappers\CategoriaMapper;
use App\Services\CategoriaService;
use App\Services\ServicesContainer;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CategoriaController extends BaseController
{
    private ICategoriaService $service;
    private IMapper $mapper;

    public function __construct(ICategoriaService $categoriaService,CategoriaMapper $mapper) {
        $this->service= $categoriaService;
        $this->mapper=$mapper;
    }

    public function addCategoria(Request $request){

        try {

            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_CATEGORIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $this->service->addCategoria($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateCategoria(Request $request,$id){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_CATEGORIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $dto->publicId=$id;
            $this->service->updateCategoria($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getCategoria(Request $request,$id){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_CATEGORIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $addChilds=boolval($request->query('childs'));
            $dto= $this->service->getCategoria($id,$addChilds);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteCategoria($id){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::DELETE_PERMIT,AccionsEnums::DELETE_CATEGORIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $this->service->deleteCategoria($id);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getCategorias(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_CATEGORIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $nombre= empty($request->query('nombre')) ? "" : $request->query('nombre');

            $addChilds=boolval($request->query('childs'));
            return new Response($this->stdResponse(data:$this->service->getCategorias($nombre,$addChilds)));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function addSubCategoria(Request $request,$id){
        try {
            
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_CATEGORIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $jsonParsed= json_decode($request->getContent());
            $dto= $this->mapper->reverse($jsonParsed);
            $this->service->addSubCategoria($id,$dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function addSubCategorias(Request $request, $id){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_CATEGORIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $jsonParsed= json_decode($request->getContent());
            if(!is_array($jsonParsed)) return new Response($this->stdResponse(false,true,"invalid content"),400);
            $subcategoriasDTO=[];
            foreach ($jsonParsed as $value) {
                $subcategoriasDTO[]=$this->mapper->reverse($value);
            }

            $this->service->addSubCategorias($id,$subcategoriasDTO);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getSubCategorias(Request $request,$id){
        try {

            if(!$this->HasAccionsPermit([AccionsEnums::READ_PERMIT,AccionsEnums::READ_CATEGORIA_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);

            $addChilds=boolval($request->query('childs'));
            return new Response($this->stdResponse(data: $this->service->getSubCategorias($id,$addChilds)));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}

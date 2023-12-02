<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IMenuService;
use App\Enums\AccionsEnums;
use App\Mappers\MenuMapper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class MenuController extends Controller 
{
    private IMenuService $service;
    private IMapper $mapper;

    public function __construct(IMenuService $service,MenuMapper $mapper) {
        $this->service=$service;
        $this->mapper=$mapper;
    }

    public function addMenu(Request $request){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::ADD_PERMIT,AccionsEnums::ADD_MENUS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            if(!isset($jsonParsed->nombre) || !isset($jsonParsed->display)) 
                return new Response($this->stdResponse(false,true,"invalid request"),400);

            $dto= $this->mapper->reverse($jsonParsed);

            $publicId=$this->service->addMenu($dto);
            return new Response($this->stdResponse(data:['publicId'=>$publicId]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateMenu(Request $request,$pid){
        try {
            if(!$this->HasAccionsPermit([AccionsEnums::UPDATE_PERMIT,AccionsEnums::UPDATE_MENUS_PERMIT])) return new Response($this->stdResponse(false,true,'401 Unauthorized'),401);
            $jsonParsed= json_decode($request->getContent());
            if(!isset($jsonParsed->nombre) || !isset($jsonParsed->display)) 
                return new Response($this->stdResponse(false,true,"invalid request"),400);

            $dto= $this->mapper->reverse($jsonParsed);
            $dto->publicId=$pid;

            $this->service->updateMenu($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteMenu($pid){
        try {
            $this->service->deleteMenu($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getMenuById($pid){
        try {
            $dto=$this->service->getMenuById($pid);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getMenus(){
        try {
            $dtos=$this->service->getMenus();
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getMenusByModulo($moduloPid){
        try {
            $dtos=$this->service->getMenusByModulo($moduloPid);
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getModulosYMenusPorUsuario(){
        try {
            $dtos=$this->service->getMenuYModulosPorUsuario();
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}

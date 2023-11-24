<?php

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\ICanalesVentaService;
use App\Contractors\Services\ICanalVentaListaPrecioService;
use App\Http\Controllers\Controller;
use App\Mappers\CanalesVentaMapper;
use App\Mappers\CanalVentaListaPrecioMapper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CanalesVentaController extends Controller
{
    private ICanalesVentaService $service;
    private ICanalVentaListaPrecioService $canalVentaListaPrecioService;
    private IMapper $mapper;
    private IMapper $canalVentaListaPrecioMapper;

    public function __construct(ICanalesVentaService $service, CanalesVentaMapper $mapper,ICanalVentaListaPrecioService $canalVentaListaPrecioService, CanalVentaListaPrecioMapper $canalVentaListPrecioMapper) {
        $this->service= $service;
        $this->mapper=$mapper;
        $this->canalVentaListaPrecioService=$canalVentaListaPrecioService;
        $this->canalVentaListaPrecioMapper= $canalVentaListPrecioMapper;
    }

    public function addCanalVenta(Request $request){
        try {
            $jsonParsed= $this->validateJsonContent($request);
            $dto= $this->mapper->reverse($jsonParsed);
            $publicId=$this->service->addCanalVenta($dto);
            return new Response($this->stdResponse(data:['publicId'=>$publicId]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateCanalVenta(Request $request,string $pid){
        try {
            $jsonParsed= $this->validateJsonContent($request);
            $dto= $this->mapper->reverse($jsonParsed);
            $dto->publicId=$pid;
            $this->service->updateCanalVenta($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getCanalVenta($pid){
        try {
            $dto= $this->service->getCanalVenta($pid);
            return new Response($this->stdResponse(data:$dto));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteCanalVenta($pid){
        try {
            $this->service->deleteCanalVenta($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getCanalesVenta(){
        try {
            $dtos=$this->service->getCanalesVenta();
            return new Response($this->stdResponse(data:$dtos));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function addListaPrecioACanal(Request $request,$pid){
        try {
            $jsonParsed= $this->validateJsonContent($request);
            if(!is_array($jsonParsed)) return new Response($this->stdResponse(false,true,'invalid request'),401);

            $dtos=[];
            array_walk($jsonParsed,function($item) use (&$dtos,$pid){
                $item->canalventaPid= $pid;
                $dto= $this->canalVentaListaPrecioMapper->reverse($item);
                array_push($dtos,$dto);
            });

            $publicIds=[];
            foreach ($dtos as $dto) {
                $publicId=$this->canalVentaListaPrecioService->addCanalVentaListaPrecio($dto);
                array_push($publicIds,$publicId);
            }
            
            return new Response($this->stdResponse(data:['publicIds'=>$publicIds]));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteListaPrecioACanal($pid){
        try {
            $this->canalVentaListaPrecioService->deleteCanalVentaListaPrecio($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getListaPreciosByCanal($pid){
        try {
            $data= $this->canalVentaListaPrecioService->getListaPreciosPorCanal($pid);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getCanalVentaPorListaPrecios($listaPid){
        try {
            $data= $this->canalVentaListaPrecioService->getCanalesPorListaPrecios($listaPid);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getListaPrecioPorCanal($pid,$listaPid){
        try {
            $data= $this->canalVentaListaPrecioService->getListaPrecioPorCanal($pid,$listaPid);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}

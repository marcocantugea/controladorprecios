<?php 

namespace App\Http\Controllers;

use App\Contractors\IMapper;
use App\Contractors\Services\IListaPreciosService;
use App\Mappers\ListaPreciosMapper;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

final class ListaPreciosController extends BaseController
{
    private IListaPreciosService $service;
    private ListaPreciosMapper $listaPrecioMapper;
    
    public function __construct(ListaPreciosMapper $mapper, IListaPreciosService $service) {
        $this->listaPrecioMapper=$mapper;
        $this->service= $service;
    }

    public function addListaPrecio(Request $request){
        try {
            $jsonParsed= $this->validateJsonContent($request);
            $dto= $this->listaPrecioMapper->reverse($jsonParsed);
            $this->service->addListaPrecios($dto);
            return new Response($this->stdResponse());

        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function updateListaPrecio(Request $request,$pid){
        try {
            $jsonParsed= $this->validateJsonContent($request);
            $dto=$this->listaPrecioMapper->reverse($jsonParsed);
            $dto->publicId=$pid;
            $this->service->updateListaPrecios($dto);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function deleteListaPrecios($pid){
        try {
            $this->service->deleteListaPrecios($pid);
            return new Response($this->stdResponse());
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getListaPrecios($pid){
        try {
            $data= $this->service->getListaPreciosById($pid);
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }

    public function getListasPrecios(){
        try {
            $data= $this->service->getListasPrecios();
            return new Response($this->stdResponse(data:$data));
        } catch (\Throwable $th) {
            return new Response($this->stdResponse(false,true,$th->getMessage()),500);
        }
    }
}

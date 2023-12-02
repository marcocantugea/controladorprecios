<?php

namespace App\Services;

use App\Contractors\IMapper;
use App\Contractors\Repositories\IMenuRepository;
use App\Contractors\Services\IMenuService;
use App\DTOs\MenuDTO;
use App\DTOs\ModuloDTO;
use Exception;

class MenuService implements IMenuService
{
    private IMenuRepository $repository;
    private IMapper $mapper;

    public function __construct(IMenuRepository $repository, IMapper $mapper) {
        $this->repository=$repository;
        $this->mapper=$mapper;
    }

    public function addMenu(MenuDTO $dto){
        try {
            $model=$this->mapper->map($dto);
            $publicId=$this->repository->add($model);
            return $publicId;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function updateMenu(MenuDTO $menu){
        try {
            $model=$this->mapper->map($menu);
            $this->repository->update($model);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function deleteMenu(string $pid){
        try {
            $this->repository->delete($pid);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function getMenuById(string $pid){
        try {
            $model=$this->repository->getById($pid);
            $dto=$this->mapper->reverse($model);
            return $dto;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function getMenus(){
        try {
            $models=$this->repository->getMenus();
            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto=$this->mapper->reverse($model);
                if(!empty($dto)) array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function getMenusByModulo(string $moduloId){
        try {
            $models=$this->repository->getMenusByModulo($moduloId);
            $dtos=[];
            array_walk($models,function($model) use (&$dtos){
                $dto=$this->mapper->reverse($model);
                if(!empty($dto)) array_push($dtos,$dto);
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
    public function getMenuYModulosPorUsuario()
    {
        try {
            $data=$this->repository->getMenuYModulosPorUsuario();
            $dtos=[];
            $data->each(function($row) use (&$dtos){
                $found=array_search($row->moduloPid,array_column($dtos, 'publicId'));
                if($found===false){
                    $moduloDto=new ModuloDTO();
                    $moduloDto->publicId=$row->moduloPid;
                    $moduloDto->nombre=$row->moduloNombre;
                    $moduloDto->display=$row->moduloDisplay;
                    $moduloDto->activo=$row->moduloActio;
                    $moduloDto->menus=[];

                    array_push($dtos,$moduloDto);
                    $found=array_search($row->moduloPid,array_column($dtos, 'publicId'));
                }

                //existe menu
                $foundMenu=array_search($row->menuPid, array_column($dtos[$found]->menus,'publicId'));
                if($foundMenu===false) {
                    $menuDto=new MenuDTO();
                    $menuDto->publicId=$row->menuPid;
                    $menuDto->nombre=$row->menuNombre;
                    $menuDto->display=$row->menuDisplay;
                    $menuDto->activo=$row->menuActivo;
                    $menuDto->essubmenu=$row->essubmenu;
                    $menuDto->orden=$row->orden;
                    $menuDto->accion=(empty($row->accion))? "" : $row->accion;

                    array_push($dtos[$found]->menus,$menuDto);
                }
                
            });

            return $dtos;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    
}

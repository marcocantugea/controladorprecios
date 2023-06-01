<?php

namespace Tests\UnitTests;

use App\Contractors\IMapper;
use App\Contractors\Models\Usuario;
use App\Contractors\Repositories\IUsuariosRepository;
use App\Mappers\UsuarioMapper;
use App\Services\AuthService;
use DateTime;
use Exception;
use Tests\TestCase;

class AuthServiceTests extends TestCase
{
    private IUsuariosRepository $usuarioRepository;
    private IMapper $mapper;
    private AuthService $service;

    protected function setUp(): void
    {
       parent::setUp();
       $this->usuarioRepository= $this->createMock(IUsuariosRepository::class);
       $this->mapper = $this->createMock(UsuarioMapper::class);

        $this->service= new AuthService($this->usuarioRepository,$this->mapper);
    }

    public function test_ShouldAuthenticatedUser_Success(){
        $usuario="usuario";
        $pass="fakepass";
        $hash=password_hash($pass,PASSWORD_DEFAULT);
        $this->usuarioRepository->expects($this->once())
                                    ->method('getUsuario')
                                    ->with($usuario)
                                    ->willReturn(new Usuario($usuario,1,uniqid(),$hash,"email.com",true,new DateTime('now')))
                                    ;

        $return=$this->service->AuthenticatedUser($usuario,$pass);

        $this->assertEquals($usuario,$return->user);
    }

    public function test_ShouldAuthenticatedUser_Fail_emptypassword(){
        $usuario="usuario";
        $pass="";
        $this->expectException(Exception::class);
        $return=$this->service->AuthenticatedUser($usuario,$pass);
    }

    public function test_ShouldAuthenticatedUser_Fail_emptyUser(){
        $usuario="";
        $pass="sfdsdf";
        $this->expectException(Exception::class);
        $return=$this->service->AuthenticatedUser($usuario,$pass);
    }

    public function test_ShouldAuthenticatedUser_Fail_NoUserFound(){
        $usuario="usuario";
        $pass="fakepass";
        $hash=password_hash($pass,PASSWORD_DEFAULT);
        $this->usuarioRepository->expects($this->once())
                                    ->method('getUsuario')
                                    ->with($usuario)
                                    ->willReturn(null)
                                    ;
        
        $this->expectException(Exception::class);

        $return=$this->service->AuthenticatedUser($usuario,$pass);
    }

    public function test_ShouldAuthenticatedUser_Fail_PasswordMissmatch(){
        $usuario="usuario";
        $pass="fakepass";
        $hash=password_hash("otropassword",PASSWORD_DEFAULT);
        $this->usuarioRepository->expects($this->once())
                                    ->method('getUsuario')
                                    ->with($usuario)
                                    ->willReturn(new Usuario($usuario,1,uniqid(),$hash,"email.com",true,new DateTime('now')))
                                    ;

        $this->expectException(Exception::class);

        $return=$this->service->AuthenticatedUser($usuario,$pass);
    }
}


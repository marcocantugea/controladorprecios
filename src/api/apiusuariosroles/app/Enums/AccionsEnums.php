<?php

namespace App\Enums;

class AccionsEnums
{
    
    public const ADD_PERMIT='ADD';
    public const UPDATE_PERMIT='UPDATE';
    public const READ_PERMIT='READ';
    public const DELETE_PERMIT='DELETE';
    public const ADD_USUARIOS_PERMIT='ADD_USUARIOS';
    public const UPDATE_USUARIOS_PERMIT='UPDATE_USUARIOS';
    public const DELETE_USUARIOS_PERMIT='DELETE_USUARIOS';
    public const READ_USUARIOS_PERMIT='READ_USUARIOS';

    public const ADD_ROL_PERMIT='ADD_ROL';
    public const UPDATE_ROL_PERMIT='UPDATE_ROL';
    public const READ_ROL_PERMIT='READ_ROL';
    public const DELETE_ROL_PERMIT='DELETE_ROL';

   
    public const ADMIN_PERMITS =[self::ADD_PERMIT,self::UPDATE_PERMIT,self::DELETE_PERMIT,self::READ_PERMIT];
    
}

<?php

namespace App\Contractors\Wrappers;

interface IAuthWrapper{
    
    function AuthenticatedUser($user,$password);
}
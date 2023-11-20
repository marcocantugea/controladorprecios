<?php

namespace App\Contractors\Wrappers;

interface IAuth {
    
    /**
     * Authenticate user
     * @param string $user
     * @param string $password
     * @return array|mixed|null
     */
    function AuthenticatedUser($user,$password);
}
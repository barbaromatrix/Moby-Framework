<?php

namespace App\Http\Middleware;

use Auth\Auth as BaseAuth;

/**
 * 
 */
class Auth extends BaseAuth
{
    /**
     * 
     */
    public function users()
    {
        return [
            0 => [
                'name'      => 'user',
                'redirect'  => '/'
            ],
            1 => [
                'name'      => 'admin',
                'redirect'  => '/Admin'
            ]
        ];
    }
}
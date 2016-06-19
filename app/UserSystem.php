<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserSystem extends Authenticatable
{
	
	protected $table 		= 'usuario';
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'login', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //'password', 'remember_token',
    		'password', 'remember_token',
    ];
}

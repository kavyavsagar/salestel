<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Customer extends Model
{
    //
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'company_name', 'location','authority_name', 'authority_email', 'authority_phone', 
        'technical_name','technical_email','technical_phone', 'refferedby'
    ];

}
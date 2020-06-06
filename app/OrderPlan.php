<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class OrderPlan extends Model
{
    //
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'order_id', 'price', 'plan', 'plan_id', 'plan_type', 'quantity', 'total'    
    ];
}
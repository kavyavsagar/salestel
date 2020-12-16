<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class OrderHistory extends Model
{
    //
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'order_id', 'order_status_id', 'comments' , 'added_by', 'last_amount', 'last_act_date'
    ];
}
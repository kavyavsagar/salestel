<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Order extends Model
{
    //
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'customer_id', 'plan_type','total_amount','order_status_id', 'activation_date' , 'sales_priority', 'exp_closing_date','exp_revenue'       
    ];
}
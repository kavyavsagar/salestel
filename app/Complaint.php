<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Complaint extends Model
{
    //
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'comp_no','customer_acc_no', 'description','priority','reported_by', 'filepath','attended_by', 'comment', 'status'       
    ];
}
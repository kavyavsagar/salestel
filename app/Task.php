<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Task extends Model
{
    //
    use HasRoles;

    protected $fillable = [
         'description','priority','start_date','start_time','assigned_by','status'       
    ];
}
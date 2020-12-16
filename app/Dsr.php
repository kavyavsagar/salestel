<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dsr extends Model
{
    //
    protected $fillable = [
        'company', 'contact_name', 'email','phone', 'location', 'remarks', 
        'dsr_status', 'refferedby', 'reminder_date', 'expected_amount', 'expected_closing'
    ];
}
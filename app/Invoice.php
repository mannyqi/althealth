<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'tblinv_info';
    public $primaryKey = 'Inv_Num';
    public $timestamps = false;
    public $incrementing = false;
}

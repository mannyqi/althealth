<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'tblinv_items';
    protected $primaryKey = 'Inv_Num';
    public $timestamps = false;
    public $incrementing = false;
}

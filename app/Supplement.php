<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplement extends Model
{
    protected $table = 'tblsupplements';
    public $primaryKey = 'Supplement_id';
    public $timestamps = false;
    public $incrementing = false;
}

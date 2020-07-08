<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'tblsupplier_info';
    public $primaryKey = 'Supplier_id';
    public $timestamps = false;
    public $incrementing = false;
}

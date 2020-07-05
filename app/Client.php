<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'tblclientinfo';
    public $primaryKey = 'Client_id';
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'tblinv_info';
    protected $primaryKey = 'Inv_Num';
    public $timestamps = false;
    public $incrementing = false;

    /**
     * Get the items for the invoice.
     */
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }
}

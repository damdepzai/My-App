<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Money extends Model
{
    protected $table='money';
    protected $fillable=['who_id','time','total','sub_total'];
    protected $casts=[ "sub_total" => "json"];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    protected $table = 'park';
    protected $fillable = ['detect','time'];
}

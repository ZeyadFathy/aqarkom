<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = ['title','country','salary','description','department','contract','level','degree','description','status'];
}

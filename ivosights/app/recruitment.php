<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class recruitment extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'Post';
    
    protected $fillable = [
        'firstName', 'lastName','email','address','contact'
    ];
}

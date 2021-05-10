<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Prerequisites extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'prerequisites';
    protected $guarded = [];

    public function getTask(){
        return $this->hasOne('App\Models\Task','_id','task_id');
    }
}

<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Task extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'tasks';
    protected $guarded = [];

    public function getPrerequisites(){
        return $this->hasMany('App\Models\Prerequisites','owner_task','_id');
    }
}

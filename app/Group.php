<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name'
    ];

    public function sheep(){
        return $this
            ->hasMany(Sheep::class,'group_id', "id");
    }
}

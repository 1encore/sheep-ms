<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sheep extends Model
{
    protected $fillable = [
        'name',
        'group_id',
        'is_alive'
    ];

    public function group(){
        return $this
            ->belongsTo(Group::class, 'group_id', 'id');
    }
}

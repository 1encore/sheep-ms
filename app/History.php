<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'name',
        'group_id',
        'sheep_id',
        'is_child',
        'day'
    ];

    public function group(){
        return $this
            ->belongsTo(Group::class, 'group_id', 'id');
    }

    public function sheep(){
        return $this
            ->belongsTo(Sheep::class, 'sheep_id', 'id');
    }
}

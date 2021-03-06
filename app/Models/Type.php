<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table="types";
    protected $fillable=['room_type'];
    use HasFactory;
    public function rooms()
    {
        return $this->hasMany(Room::class,'type_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table="views";
    protected $fillable=['view_statu'];
    use HasFactory;
    public function rooms()
    {
        return $this->hasMany(Room::class,'view_id','id');
    }
}

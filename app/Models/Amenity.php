<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table="amenities";
    protected $fillable=[
        'description','room_id'
    ];
    use HasFactory;
    public function rooms()
    {
        return $this->belongsTo(Room::class,'room_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table='rooms';
    protected $fillable = [
        'price','bed_number','type_id','view_id','picture','size','is_suite'
    ];
    use HasFactory;
    public function amenities()
    {
        return $this->hasMany(Amenity::class,'room_id',"id");
    }
    public function features()
    {
        return $this->hasMany(Feature::class,'room_id',"id");
    }
    public function views()
    {
        return $this->belongsTo(View::class,'view_id','id');
    }
    public function types()
    {
        return $this->belongsTo(Type::class,'type_id',"id");
    }
}

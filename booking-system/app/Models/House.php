<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'settlement_id',
        'beds_count',
        'object_type_id',
        'description',
    ];

    public function settlement()
    {
        return $this->belongsTo(Settlement::class);
    }

    public function objectType()
    {
        return $this->belongsTo(ObjectType::class);
    }
    
    public function images()
    {
    return $this->hasMany(HouseImage::class);
    }

    public function mainImage()
    {
    return $this->hasOne(HouseImage::class)->where('is_main', true);
    }
}

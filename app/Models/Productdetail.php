<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productdetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','unit_id','unit_value','color_id','size_id','purchase_price','selling_price','tax','discount','total_price','image','status','created_at','updated_at','deleted_at'];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->created_at = now();
        });

        static::updating(function ($model) {
            $model->updated_at = now();
        });
    }

    public function product()
    {
        return $this->belongsTo(product::class, "product_id", "id");
    }

    public function products()
    {
        return $this->hasMany(product::class,"product_id","id");
    }
    //Unit
    public function unit()
    {
        return $this->belongsTo(unit::class, "unit_id", "id");
    }

    public function units()
    {
        return $this->hasMany(unit::class,"unit_id","id");
    }
    //Color
    public function color()
    {
        return $this->belongsTo(color::class, "color_id", "id");
    }

    public function colors()
    {
        return $this->hasMany(color::class,"color_id","id");
    }
    //Size
    public function size()
    {
        return $this->belongsTo(size::class, "size_id", "id");
    }

    public function sizes()
    {
        return $this->hasMany(size::class,"size_id","id");
    }

    public function getImageAttribute($value)
    {

        return (!is_null($value)) ? env('APP_URL') . '/public/storage/' . $value : null;
    }


    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;

class Material extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [ 'material_name','category_id','opening_balance' ];


    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function movements() {
        return $this->hasMany(InwardOutward::class);
    }

    public function getCurrentBalanceAttribute() {
        return $this->opening_balance + $this->movements()->sum('quantity');
    }

    // public static function booted()
    // {
    //     static::created(function (Zone $zone)
    //     {
    //         self::where('id', $zone->id)->update([
    //             'created_by'=> Auth::user()->id,
    //         ]);
    //     });
    //     static::updated(function (Zone $zone)
    //     {
    //         self::where('id', $zone->id)->update([
    //             'updated_by'=> Auth::user()->id,
    //         ]);
    //     });
    //     static::deleted(function (Zone $zone)
    //     {
    //         self::where('id', $zone->id)->update([
    //             'deleted_by'=> Auth::user()->id,
    //         ]);
    //     });
    // }

}

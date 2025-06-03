<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Auth;


class Category extends BaseModel
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['name'];

    // public static function booted()
    // {
    //     static::created(function (Category $category)
    //     {
    //         self::where('id', $category->id)->update([
    //             'created_by'=> Auth::user()->id,
    //         ]);
    //     });
    //     static::updated(function (Category $category)
    //     {
    //         self::where('id', $category->id)->update([
    //             'updated_by'=> Auth::user()->id,
    //         ]);
    //     });
    //     static::deleted(function (Category $category)
    //     {
    //         self::where('id', $category->id)->update([
    //             'deleted_by'=> Auth::user()->id,
    //         ]);
    //     });
    // }
}

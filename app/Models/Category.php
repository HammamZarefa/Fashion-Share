<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category_id', 'image','section_id'];
    public $translatable = ['name'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function section(){
        return  $this->belongsTo(Section::class,'section_id');
    }

    public function sizes(){
        return $this->hasMany(Size::class,'category_id');
    }
}

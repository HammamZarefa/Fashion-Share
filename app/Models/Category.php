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
        return $this->hasMany(Product::class);
    }

    public function section(){
        return  $this->belongsTo(Section::class,'section_id');
    }

    public function sizes(){
        return $this->hasMany(Size::class,'category_id');
    }

    public function styles(){
        return $this->hasMany(Style::class,'category_id');
    }

    /**
     * Get all of the tags for the post.
     */
    public function branches()
    {
        return $this->morphToMany(Branch::class, 'branchable','branchables');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $translatable = ['name'];

    public function products()
    {
        $this->hasMany(Product::class);
    }

    public function category(){
        return $this->hasMany(Category::class,'section_id');
    }

    public function styles(){
        return $this->hasMany(Style::class,'section_id');
    }

    public function sizes(){
        return $this->hasMany(Size::class,'section_id');
    }

    /**
     * Get all of the tags for the post.
     */
    public function branches()
    {
        return $this->morphToMany(Branch::class, 'branchable','branchables');
    }
}

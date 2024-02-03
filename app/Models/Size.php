<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Size extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $translatable = ['name'];

    public function products()
    {
        $this->hasMany(Product::class);
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function section(){
        return $this->belongsTo(Section::class,'section_id');
    }

    /**
     * Get all of the tags for the post.
     */
    public function branches()
    {
        return $this->morphToMany(Branch::class, 'branchable','branchables');
    }
}

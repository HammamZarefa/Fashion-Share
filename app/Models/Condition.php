<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $translatable = ['name'];

    public function products()
    {
        $this->hasMany(Product::class);
    }

    /**
     * Get all of the tags for the post.
     */
    public function branches()
    {
        return $this->morphToMany(Branch::class, 'branchable','branchables');
    }
}

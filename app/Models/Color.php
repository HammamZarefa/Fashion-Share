<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Color extends Model
{
    use HasFactory;

    protected $fillable = ['name','Hexcolor'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $translatable = ['name'];

    public function products()
    {
        $this->hasMany(Product::class);
    }
}

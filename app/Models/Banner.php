<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Banner extends Model
{
    use HasFactory, HasTranslations;


    protected $fillable = ['name', 'description', 'button_label', 'image'];

    public $translatable = ['name', 'description', 'button_label'];
}

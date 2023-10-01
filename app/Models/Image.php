<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $guarded = ['id'];

    public function imagable()
    {
        return $this->morphTo();
    }
}

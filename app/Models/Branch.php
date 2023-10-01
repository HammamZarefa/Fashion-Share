<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'working_hours', 'phone', 'whatsapp'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $translatable = ['name'];

    public function products()
    {
        $this->hasMany(Product::class);
    }
}

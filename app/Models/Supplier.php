<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'mobile'];

    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class,'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'supplier_id');
    }
}

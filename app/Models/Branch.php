<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'address', 'working_hours', 'phone', 'whatsapp'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $translatable = ['name','address'];

    public function products()
    {
       return $this->hasMany(Product::class);
    }

    public function Admin()
    {
       return $this->hasOne(Admin::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'mobile','branch_id','total_amount'];

    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class,'user_id');
    }

    public function branch(): BelongsTo
    {
        return  $this->belongsTo(Branch::class,'branch_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class,'supplier_id');
    }

    public function supplierPayments()
    {
        return $this->hasMany(SupplierPayment::class,'supplier_id');
    }
}

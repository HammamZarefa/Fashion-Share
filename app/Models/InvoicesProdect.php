<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesProdect extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function products(){
        return $this->belongsToMany(Product::class,'product_invoices_product');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}

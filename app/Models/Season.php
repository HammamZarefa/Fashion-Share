<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $translatable = ['name'];

    /**
     * Get all of the tags for the post.
     */
    public function branches()
    {
        return $this->morphToMany(Branch::class, 'branchable','branchables');
    }
}

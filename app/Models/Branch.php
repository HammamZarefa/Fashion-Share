<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'address', 'working_hours', 'phone', 'whatsapp','location','latitude','longitude','code', 'mobile','social'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public $translatable = ['name','address'];

    public function suppliers()
    {
        return  $this->hasMany(Supplier::class,'branch_id');
    }

    public function products()
    {
       return $this->hasMany(Product::class);
    }

    public function Admin()
    {
       return $this->hasOne(Admin::class);
    }

    public function categories()
    {
        return $this->morphedByMany(Category::class, 'branchable','branchables');
    }

    public function sections()
    {
        return $this->morphedByMany(Section::class, 'branchable','branchables');
    }

    public function sizes()
    {
        return $this->morphedByMany(Size::class, 'branchable','branchables');
    }

    public function colors()
    {
        return $this->morphedByMany(Color::class, 'branchable','branchables');
    }

    public function conditions()
    {
        return $this->morphedByMany(Condition::class, 'branchable','branchables');
    }

    public function materials()
    {
        return $this->morphedByMany(Material::class, 'branchable','branchables');
    }

    public function seasons()
    {
        return $this->morphedByMany(Season::class, 'branchable','branchables');
    }

    public function styles()
    {
        return $this->morphedByMany(Style::class, 'branchable','branchables');
    }

    public function model($model){

        $model = Str::lower($model);
        if ($model == 'section'){
            return $this->morphedByMany(Section::class, 'branchable','branchables');
        }elseif ($model == 'condition'){
            return $this->morphedByMany(Condition::class, 'branchable','branchables');
        }elseif ($model == 'material'){
            return $this->morphedByMany(Material::class, 'branchable','branchables');
        }elseif ($model == 'season'){
            return $this->morphedByMany(Season::class, 'branchable','branchables');
        }
    }
}

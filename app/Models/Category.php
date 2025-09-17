<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['name_en', 'name_ar', 'image'];
    public function items()
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function freelancerCategory(){
        return $this->hasMany(FreelancerCategory::class, 'category_id', 'id');
    }

    public function cardCategory(){
        return $this->hasMany(CardCategory::class, 'category_id', 'id');
    }
}

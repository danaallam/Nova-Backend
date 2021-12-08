<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerCategory extends Model
{
    use HasFactory;

    public function freelancer(){
        return $this->belongsTo(User::class, 'freelancer_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

}

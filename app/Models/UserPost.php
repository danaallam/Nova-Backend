<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    use HasFactory;

    public function freelancer(){
        return $this->belongsTo(User::class, 'freelancer_id', 'id');
    }

}

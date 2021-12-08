<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreelancerCard extends Model
{
    use HasFactory;
    public function freelancer(){
        return $this->belongsTo(User::class, 'freelancer_id', 'id');
    }

    public function card(){
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }
}

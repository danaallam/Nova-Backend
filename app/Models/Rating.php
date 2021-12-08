<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    public function freelancer(){
        return $this->belongsTo(Freelancer::class, 'freelancer_id', 'id');
    }

    public function card(){
        return $this->belongsTo(Card::class, 'card_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    public function savedCards(){
        return $this->hasMany(Saved::class, 'card_id', 'id');
    }

    public function users(){
        return $this->hasMany(FreelancerCard::class, 'card_id', 'id');
    }

    public function categories(){
        return $this->hasMany(CardCategory::class, 'card_id', 'id');
    }

    public function posts(){
        return $this->hasMany(Post::class, 'card_id', 'id');
    }

    public function designer(){
        return $this->belongsTo(Designer::class, 'designer_id', 'id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    protected $fillable = ['social_id', 'service'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

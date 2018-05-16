<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //polimorphic berfungsi untuk menghubungkan lebih banyak model
    public function commentable()
    {
      return $this->morphTo();
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }
}

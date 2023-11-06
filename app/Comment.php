<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content','user_id','forum_id',
    ];

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    
}

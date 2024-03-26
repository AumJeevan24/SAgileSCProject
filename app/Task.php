<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description','user_names', 'order', 'start_date','end_date', 'proj_id', 'newTask_update'];

    public $primaryKey = 'id';

    public $foreignKey = ['userstory_id','sprint_id','status_id'];
    
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}

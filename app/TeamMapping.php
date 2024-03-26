<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMapping extends Model
{
    protected $table = 'teammappings';

    protected $fillable = ['role_id','username','team_id'];

    public $primaryKey = 'teammapping_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'team_id');
    }



}

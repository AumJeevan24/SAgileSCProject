<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = ['team_name','proj_name','team_names'];

    public $primaryKey = 'team_id';
}

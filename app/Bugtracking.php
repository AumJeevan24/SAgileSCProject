<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bugtracking extends Model
{
    protected $table = 'bugtrack';
    
    protected $fillable = [
        'title',
        'description',
        'severity',
        'status',
        'flow',
        'expected_results',
        'actual_results',
        'attachment',
        'assigned_to',
        'reported_by'
    ];
// Define relationships
public function assignee()
{
    return $this->belongsTo(User::class, 'assigned_to');
}

public function reporter()
{
    return $this->belongsTo(User::class, 'reported_by');
}
}

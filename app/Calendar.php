<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{

    protected $table = 'calendar';

    protected $fillable = ['title', 'start_date', 'end_date'];
}
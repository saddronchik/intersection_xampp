<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['id_citizen ','who_noticed','where_noticed','detection_date'];
    use HasFactory;
}

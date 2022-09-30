<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['id_citizen','full_name','date_birth','who_noticed','where_noticed','detection_date','user','id_user'];
    use HasFactory;
}

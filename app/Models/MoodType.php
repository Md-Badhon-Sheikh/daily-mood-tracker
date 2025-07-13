<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoodType extends Model
{
    use HasFactory;
    protected $table = 'mood_types';
    protected $fillable = ['mood_type', 'priority'];
}

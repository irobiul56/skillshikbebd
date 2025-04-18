<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $guarded = [];

    public function Course()
    {
        return $this->belongsToMany(Course::class, 'course_tool');
    }
}

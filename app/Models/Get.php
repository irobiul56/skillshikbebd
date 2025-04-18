<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Get extends Model
{
    protected $guarded = [];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_get');
    }
}

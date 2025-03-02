<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded =[];

    public function curriculums()
    {
        return $this->hasMany(CourseCurriculum::class);
    }
}

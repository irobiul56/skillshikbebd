<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded =[];

    public function curriculums()
    {
        return $this->hasMany(Curriculum::class);
    }

    public function liveclass()
    {
        return $this->hasMany(LiveClass::class);
    }

    // app/Models/Course.php
    public function checkedOutUsers()
    {
        return $this->belongsToMany(User::class, 'course_checkouts')
                    ->withPivot(['payment_method', 'transaction_id', 'amount', 'status'])
                    ->wherePivot('status', 'active');
    }
    
}

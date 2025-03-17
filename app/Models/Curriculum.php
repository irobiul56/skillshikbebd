<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'curriculums'; // Explicitly specify the table name

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'week',
        'topic',
        'details',
    ];

    /**
     * Get the course that owns the curriculum.
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
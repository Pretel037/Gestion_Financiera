<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'codigo', 
        'organization_id', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];




    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }


    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class); 
    }



    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }


    
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }
    
    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_user')
            ->withTimestamps();
    }
}
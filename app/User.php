<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * A user can create many tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdTasks()
    {
        return $this->hasMany('App\Task', 'creator_id');
    }

    /**
     * A user can have many tasks to perform
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assignedTasks()
    {
        return $this->hasMany('App\Task', 'executor_id');
    }
}

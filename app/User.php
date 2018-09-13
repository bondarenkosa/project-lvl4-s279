<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Requests\TaskRequest;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * A user can create many tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function createdTasks()
    {
        return $this->hasMany('App\Task', 'creator_id');
    }

    public function createTask(TaskRequest $request)
    {
        $task = $this->createdTasks()->create($request->all());
        $task->syncTags($request->input('tag_list', []));

        return $task;
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

    public function scopeHasTasks($query)
    {
        return $query->withTrashed()->has('assignedTasks');
    }
}

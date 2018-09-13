<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status', 'executor_id',
    ];

    /**
     * A task belongs to a creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id')->withTrashed();
    }

    /**
     * A task belongs to a executor.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedTo()
    {
        return $this->belongsTo('App\User', 'executor_id')->withTrashed();
    }

    /**
     * Get the tags associated with the given task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }

    /**
     * Get a list of tag ids associated with the current task.
     *
     * @return array
     */
    public function getTagListAttribute()
    {
        return $this->tags->pluck('name');
    }

    public function syncTags(array $tagNames)
    {
        $tagIds = array_map(function ($value) {
            $tag = Tag::firstOrCreate(['name' => $value]);
            return $tag->id;
        }, $tagNames);

        return $this->tags()->sync($tagIds);
    }

    public function scopeFiltered($query, $filter)
    {
        $query->when(isset($filter['executor_id']), function ($query) use ($filter) {
            return $query->where('executor_id', $filter['executor_id']);
        });

        $query->when(isset($filter['status']), function ($query) use ($filter) {
            return $query->where('status', $filter['status']);
        });

        $query->when(isset($filter['only_my']), function ($query) {
            return $query->where('creator_id', auth()->user()->id);
        });

        $query->when(isset($filter['tag_list']), function ($query) use ($filter) {
            return $query->whereHas('tags', function ($query) use ($filter) {
                $query->whereIn('id', $filter['tag_list']);
            });
        });

        return $query;
    }
}

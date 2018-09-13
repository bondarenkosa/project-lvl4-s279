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
        if (isset($filter['executor_id'])) {
            $query->withExecutor($filter['executor_id']);
        }

        if (isset($filter['status'])) {
            $query->withStatus($filter['status']);
        }

        if (isset($filter['tag_list'])) {
            $query->withTags($filter['tag_list']);
        }

        if (isset($filter['only_my'])) {
            $query->onlyMy();
        }

        return $query;
    }

    public function scopeOnlyMy($query)
    {
        return $query->where('creator_id', auth()->user()->id);
    }

    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeWithExecutor($query, $executor_id)
    {
        return $query->where('executor_id', $executor_id);
    }

    public function scopeWithTags($query, $tags)
    {
        return $query->whereHas('tags', function ($query) use ($tags) {
            $query->whereIn('id', $tags);
        });
    }
}

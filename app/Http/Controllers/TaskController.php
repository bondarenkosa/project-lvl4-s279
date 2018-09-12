<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Task;
use App\User;
use App\TaskStatus;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the tasks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $executor_id = $request->input('executor_id');
        $status = $request->input('status');
        $tagList = $request->input('tag_list');
        $isMyTasks = $request->input('my_tasks');

        $query = Task::query();

        $query->when($executor_id, function ($query, $executor_id) {
            return $query->where('executor_id', $executor_id);
        });

        $query->when($status, function ($query, $status) {
            return $query->where('status', $status);
        });

        $query->when($isMyTasks, function ($query) {
            return $query->where('creator_id', auth()->user()->id);
        });

        $query->when($tagList, function ($query, $tagList) {
            return $query->whereHas('tags', function ($query) use ($tagList) {
                $query->whereIn('id', $tagList);
            });
        });

        $tasks = $query->get();
        $statuses = TaskStatus::pluck('name', 'name');
        $users = User::pluck('name', 'id');
        $tags = Tag::pluck('name', 'id');

        $data = compact('tasks', 'statuses', 'users', 'tags', 'executor_id', 'status', 'tagList', 'isMyTasks');

        return view('tasks.index', $data);
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = TaskStatus::pluck('name', 'name');
        $users = User::pluck('name', 'id');
        $tags = Tag::pluck('name', 'name');

        return view('tasks.create', compact('statuses', 'users', 'tags'));
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        auth()->user()->createTask($request);

        flash('New task has been successfully created')->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Display the task.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the task.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $statuses = TaskStatus::pluck('name', 'name');
        $users = User::pluck('name', 'id');
        $tags = Tag::pluck('name', 'name');

        return view('tasks.edit', compact('task', 'statuses', 'users', 'tags'));
    }

    /**
     * Update the task in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, Task $task)
    {
        $task->update($request->all());

        $task->syncTags($request->input('tag_list', []));

        flash('The task has been successfully updated')->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the task from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        flash('The task has been successfully deleted')->success();

        return redirect()->route('tasks.index');
    }
}

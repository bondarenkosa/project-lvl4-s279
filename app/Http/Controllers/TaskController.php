<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();

        return view('tasks.index', compact('tasks'));
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

        return view('tasks.create', compact('statuses', 'users'));
    }

    /**
     * Store a newly created task in storage.
     *
     * @param  \App\Http\Requests\TaskRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $task = new Task($request->all());
        auth()->user()->createTask($task);

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

        return view('tasks.edit', compact('task', 'statuses', 'users'));
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

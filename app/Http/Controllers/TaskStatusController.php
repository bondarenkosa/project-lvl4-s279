<?php

namespace App\Http\Controllers;

use App\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the task statuses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = TaskStatus::all();

        return view('taskstatuses.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new task status.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('taskstatuses.create');
    }

    /**
     * Store a newly created task status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required']);

        TaskStatus::create($request->all());

        flash('New task status has been successfully created')->success();

        return redirect()->route('taskstatuses.index');
    }

    /**
     * Display the task status.
     *
     * @param  \App\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function show(TaskStatus $taskStatus)
    {
        return view('taskstatuses.show', compact('taskStatus'));
    }

    /**
     * Show the form for editing the task status.
     *
     * @param  \App\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        return view('taskstatuses.edit', compact('taskStatus'));
    }

    /**
     * Update the task status in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $this->validate($request, ['name' => 'required']);

        $taskStatus->update($request->all());

        flash('The task status has been successfully updated')->success();

        return redirect()->route('taskstatuses.index');
    }

    /**
     * Remove the task status from storage.
     *
     * @param  \App\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaskStatus $taskStatus)
    {
        $taskStatus->delete();

        flash('The task status has been successfully deleted')->success();

        return redirect()->route('taskstatuses.index');
    }
}

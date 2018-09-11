<?php

namespace Tests\Unit;

use App\User;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected $data;
    protected $task;
    protected $urlParams;

    public function setUp()
    {
        parent::setUp();

        $this->data = [
            'name' => 'Task',
            'description' => 'task description',
        ];

        $this->task = factory(Task::class)->create($this->data);
        $this->urlParams = ['task' => $this->task->id];
        $this->actingAs(User::first());
    }

    public function testGetTaskList()
    {
        $response = $this->get(route('tasks.index'));

        $response->assertOk();
    }

    public function testGetTaskCreateForm()
    {
        $response = $this->get(route('tasks.create'));

        $response->assertOk();
    }

    public function testCreateNewTask()
    {
        $taskData = factory(Task::class)->make()->toArray();

        $response = $this->post(route('tasks.store'), $taskData);

        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function testGetTaskEditForm()
    {
        $response = $this->get(route('tasks.edit', $this->urlParams));

        $response->assertOk();
    }

    public function testTaskPatch()
    {
        $newData = array_merge(
            $this->task->toArray(),
            ['name' => 'Edited Task']
        );

        $response = $this->call(
            'PATCH',
            route('tasks.update', $this->urlParams),
            $newData
        );

        $this->assertDatabaseHas('tasks', $newData);
    }

    public function testGetTaskView()
    {
        $response = $this->get(route('tasks.show', $this->urlParams));

        $response->assertOk();
    }

    public function testTaskDelete()
    {
        $response = $this->call('DELETE', route('tasks.destroy', $this->urlParams));

        $this->assertDatabaseMissing('tasks', $this->data);
    }
}
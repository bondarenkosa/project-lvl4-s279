<?php

namespace Tests\Feature;

use App\User;
use App\TaskStatus;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    protected $data;
    protected $taskStatus;
    protected $urlParams;

    public function setUp()
    {
        parent::setUp();

        $this->data = ['name' => 'Task Status'];

        $this->taskStatus = factory(TaskStatus::class)->create($this->data);

        $this->urlParams = ['taskstatus' => $this->taskStatus->id];

        $user = factory(User::class)->create();
        $this->actingAs($user);
    }

    public function testGetTaskStatusesList()
    {
        $response = $this->get(route('taskstatuses.index'));

        $response->assertOk();
    }

    public function testGetTaskStatusCreateForm()
    {
        $response = $this->get(route('taskstatuses.create'));

        $response->assertOk();
    }

    public function testCreateNewTaskStatus()
    {
        $newData = ['name' => 'New Status'];
        $response = $this->post(route('taskstatuses.store'), $newData);

        $this->assertDatabaseHas('task_statuses', $newData);
    }

    public function testGetTaskStatusEditForm()
    {
        $response = $this->get(route('taskstatuses.edit', $this->urlParams));

        $response->assertOk();
    }

    public function testTaskStatusPatch()
    {
        $newData = ['name' => 'Edited TaskStatus'];

        $response = $this->call(
            'PATCH',
            route('taskstatuses.update', $this->urlParams),
            $newData
        );

        $this->assertDatabaseHas('task_statuses', $newData);
    }

    public function testGetTaskStatusView()
    {
        $response = $this->get(route('taskstatuses.show', $this->urlParams));

        $response->assertOk();
    }

    public function testTaskStatusDelete()
    {
        $response = $this->call('DELETE', route('taskstatuses.destroy', $this->urlParams));

        $this->assertDatabaseMissing('task_statuses', $this->data);
    }
}

<?php

use App\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusesTableSeeder extends Seeder
{
    private $statuses = [
        'New',
        'In Progress',
        'In Testing',
        'Completed',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->statuses as $status) {
            TaskStatus::firstOrCreate(['name' => $status]);
        }
    }
}

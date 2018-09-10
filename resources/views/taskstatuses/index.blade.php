@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="display-4">Task Statuses</h2>
    <p class="my-3">
        <a href="{{ route('taskstatuses.create') }}" class="btn btn-primary">Add new Task Status</a>
    </p>
    @if (count($taskStatuses))
        <div class="card-columns">
            @each('taskstatuses._card', $taskStatuses, 'taskStatus')
        </div>
     @endif

</div>
@endsection

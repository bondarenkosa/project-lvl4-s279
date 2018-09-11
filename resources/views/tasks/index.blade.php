@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="display-4">Tasks</h2>
    <p class="my-3">
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Add new Task</a>
    </p>
    @if (count($tasks))
        <div class="card-columns">
            @each('tasks._card', $tasks, 'task')
        </div>
     @endif

</div>
@endsection

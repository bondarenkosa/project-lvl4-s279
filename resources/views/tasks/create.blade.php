@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Create task</h5>
                    <hr>
                    {!! Form::open(['route' => 'tasks.store']) !!}
                        @include('tasks._formfields', ['submitButtonText' => 'Create'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

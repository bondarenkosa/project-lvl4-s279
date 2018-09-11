@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">

                    <div class="btn-group" role="group">
                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Users
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                          <a class="dropdown-item" href="{{ route('users') }}">List</a>
                        </div>
                      </div>
                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop2" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Task statuses
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
                          <a class="dropdown-item" href="{{ route('taskstatuses.index') }}">List</a>
                          <a class="dropdown-item" href="{{ route('taskstatuses.create') }}">Create new</a>
                        </div>
                      </div>
                      <div class="btn-group" role="group">
                        <button id="btnGroupDrop3" type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Tasks
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop3">
                          <a class="dropdown-item" href="{{ route('tasks.index') }}">List</a>
                          <a class="dropdown-item" href="{{ route('tasks.create') }}">Create new</a>
                        </div>
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

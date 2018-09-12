<div class="container">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Search tasks</h5>
            <hr>
            {!! Form::open(['route' => 'tasks.index', 'method' => 'get', 'id' => 'filter-form']) !!}
              <div class="form-row">

                <div class="col-md-4 mb-3">
                    {!! Form::label('tag_list', 'Tags') !!}
                    {!! Form::select('tag_list[]', $tags, $tagList, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
                </div>

                <div class="col-md-4 mb-3">
                  {!! Form::label('status', 'Status') !!}
                  {!! Form::select('status', $statuses, $status, ['class' => 'form-control', 'placeholder' => 'Choose a status...']) !!}
                </div>

                <div class="col-md-4 mb-3">
                  {!! Form::label('executor_id', 'Executor') !!}
                  {!! Form::select('executor_id', $users, $executor_id, ['class' => 'form-control', 'placeholder' => 'Choose a executor...']) !!}
                </div>

              </div>

              <div class="form-row">
                  <div class="col-md-4 mb-3">
                      {!! Form::label('my_tasks', 'Tasks created by me') !!}
                      {!! Form::checkbox('my_tasks', 'true', $isMyTasks) !!}
                  </div>
              </div>

              {!! Form::submit('Search', ['class' => 'btn btn-primary mr-5']) !!}
              <a class="btn btn-primary" href="{{ route('tasks.index') }}">Reset</a>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#tag_list').select2({
                allowClear: true,
                placeholder: 'Choose a tag...',
            });
        });
    </script>
@endsection

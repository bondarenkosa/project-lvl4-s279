<div class="container">
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Search tasks</h5>
            <hr>
            {!! Form::open(['route' => 'tasks.index', 'method' => 'get', 'id' => 'filter-form']) !!}
              <div class="form-row">

                <div class="col-md-4 mb-3">
                    {!! Form::label('filter[tag_list]', 'Tags') !!}
                    {!! Form::select('filter[tag_list][]', $tags, isset($filter['tag_list']) ? $filter['tag_list'] : null, ['id' => 'tag_list', 'class' => 'form-control', 'multiple']) !!}
                </div>

                <div class="col-md-4 mb-3">
                  {!! Form::label('filter[status]', 'Status') !!}
                  {!! Form::select('filter[status]', $statuses, $filter['status'], ['class' => 'form-control', 'placeholder' => 'Choose a status...']) !!}
                </div>

                <div class="col-md-4 mb-3">
                  {!! Form::label('filter[executor_id]', 'Executor') !!}
                  {!! Form::select('filter[executor_id]', $executors, $filter['executor_id'], ['class' => 'form-control', 'placeholder' => 'Choose a executor...']) !!}
                </div>

              </div>

              <div class="form-row">
                  <div class="col-md-4 mb-3">
                      {!! Form::label('filter[only_my]', 'Tasks created by me') !!}
                      {!! Form::checkbox('filter[only_my]', '1', isset($filter['only_my'])) !!}
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

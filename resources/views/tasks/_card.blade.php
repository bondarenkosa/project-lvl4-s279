<div class="card" style="width: 24rem;">
    <div class="card-body">
        <h5 class="card-title ml-2">{{ $task->name }} <span class="badge badge-secondary">{{ $task->status }}</span></h5>
        <hr>
        <p>{{ $task->description }}</p>
        <dl class="row">
          <dt class="col-sm-3">Creator</dt>
          <dd class="col-sm-9">{{ $task->creator->name }}</dd>

          <dt class="col-sm-3">Executor</dt>
          <dd class="col-sm-9">{{ $task->assignedTo->name }}</dd>
        </dl>
        <hr>
        <a href="{{ route('tasks.edit', ['tasks' => $task->id]) }}" class="btn btn-link">Edit</a>
        <div class="float-right">
            <form method="post" class="form-inline" action="{{ route('tasks.destroy', ['task' => $task->id]) }}">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-link text-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </div>
    </div>
</div>

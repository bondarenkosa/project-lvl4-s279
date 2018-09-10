<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title ml-2">{{ $taskStatus->name }}</h5>
        <hr>
      <a href="{{ route('taskstatuses.edit', ['taskstatus' => $taskStatus->id]) }}" class="btn btn-link">Edit</a>
      <div class="float-right">
          <form method="post" class="form-inline" action="{{ route('taskstatuses.destroy', ['taskstatus' => $taskStatus->id]) }}">
              @method('DELETE')
              @csrf
              <button type="submit" class="btn btn-link text-danger" onclick="return confirm('Are you sure?')">Delete</button>
          </form>
      </div>
    </div>
</div>

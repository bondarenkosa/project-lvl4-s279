@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="display-4">List of Users</h2>
    @if (count($users))
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Updated at</th>
              <th scope="col">Created at</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                 <td>{{ $user->name }}</td>
                 <td>{{ $user->email }}</td>
                 <td>{{ $user->updated_at }}</td>
                 <td>{{ $user->created_at }}</td>
              </tr>
           @endforeach
          </tbody>
      </table>
      {{ $users->links() }}
     @endif
</div>
@endsection

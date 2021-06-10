@extends('templates.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="float-start">Users</h1>
            <a href="{{ route('admin.users.create') }}"
               class="btn btn-sm btn-success float-end"
               role="button">Create User</a>
        </div>
    </div>


    <div class="card table-container-card">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary" role="button">Edit</a>
                        <button type="button"
                           class="btn btn-sm btn-danger"
                           onclick="event.preventDefault();
                            document.getElementById('delete-user-form-{{ $user->id }}').submit()"
                           role="button">Delete</button>
                        <form
                            method="POST"
                            action="{{ route('admin.users.destroy', $user->id) }}"
                            style="display:none;"
                            id="delete-user-form-{{ $user->id }}"
                        >
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $users->links() }}
    </div>
@endsection

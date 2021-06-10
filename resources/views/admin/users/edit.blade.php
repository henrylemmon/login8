@extends('templates.main')

@section('content')
    <h1>Edit User</h1>
    <div class="card form-container-card">
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @method('PATCH')
            @include('admin.users.partials.form')
        </form>
    </div>
@endsection

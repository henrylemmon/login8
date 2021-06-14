@extends('templates.main')

@section('content')
    <h1 class="mt-4">Update Profile</h1>
    <div class="card form-container-card">
        <form method="POST" action="{{ route('user-profile-information.update') }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    name="name"
                    type="text"
                    class="form-control @error('name') is-invalid @enderror"
                    id="name"
                    aria-describedby="name"
                    value="{{ auth()->user()->name }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                    name="email"
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    aria-describedby="email"
                    value="{{ auth()->user()->email }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

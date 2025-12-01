@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('messages.manage_roles') }}</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>{{ __('Ime') }}</th>
                                <th>Email</th>
                                <th>{{ __('messages.role') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <form action="{{ route('admin.users.role', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                                <option value="student" {{ $user->role == 'student' ? 'selected' : '' }}>
                                                    {{ __('messages.student') }}
                                                </option>
                                                <option value="nastavnik" {{ $user->role == 'nastavnik' ? 'selected' : '' }}>
                                                    {{ __('messages.nastavnik') }}
                                                </option>
                                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                                                    {{ __('messages.admin') }}
                                                </option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                    <span class="badge bg-{{ $user->role == 'admin' ? 'danger' : ($user->role == 'nastavnik' ? 'primary' : 'secondary') }}">
                                        {{ __('messages.'.$user->role) }}
                                    </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

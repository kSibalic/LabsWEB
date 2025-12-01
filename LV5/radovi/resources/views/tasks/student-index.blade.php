@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('tasks.available_tasks') }}</div>

                    <div class="card-body">
                        @if($tasks->isEmpty())
                            <p class="text-muted">{{ __('tasks.no_tasks') }}</p>
                        @else
                            <div class="alert alert-info">
                                Možete se prijaviti na maksimalno 5 radova.
                            </div>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{ __('tasks.task_name') }}</th>
                                    <th>Nastavnik</th>
                                    <th>{{ __('tasks.study_type') }}</th>
                                    <th>{{ __('tasks.task_description') }}</th>
                                    <th>{{ __('messages.actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>
                                            @if(app()->getLocale() == 'en')
                                                {{ $task->naziv_rada_en }}
                                            @else
                                                {{ $task->naziv_rada }}
                                            @endif
                                        </td>
                                        <td>{{ $task->nastavnik->name }}</td>
                                        <td>{{ __('tasks.'.$task->tip_studija) }}</td>
                                        <td>
                                            @if(app()->getLocale() == 'en')
                                                {{ Str::limit($task->zadatak_rada_en, 100) }}
                                            @else
                                                {{ Str::limit($task->zadatak_rada, 100) }}
                                            @endif
                                        </td>
                                        <td>
                                            @if(in_array($task->id, $myApplications))
                                                <span class="badge bg-success">Prijavljeni</span>
                                            @else
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#applyModal{{ $task->id }}">
                                                    {{ __('tasks.apply') }}
                                                </button>
                                            @endif
                                        </td>
                                    </tr>

                                    <!-- Modal za prijavu -->
                                    <div class="modal fade" id="applyModal{{ $task->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Prijavi se na rad</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('tasks.apply', $task) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">{{ __('tasks.priority') }} (1-5)</label>
                                                            <select name="prioritet" class="form-select" required>
                                                                @for($i = 1; $i <= 5; $i++)
                                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                            <small class="text-muted">Niži broj = veći prioritet. Nastavnik može prihvatiti samo prioritet 1.</small>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                                                        <button type="submit" class="btn btn-primary">Prijavi se</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

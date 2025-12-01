@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>{{ __('tasks.my_tasks') }}</span>
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                            {{ __('tasks.add_task') }}
                        </a>
                    </div>

                    <div class="card-body">
                        @if($tasks->isEmpty())
                            <p class="text-muted">{{ __('tasks.no_tasks') }}</p>
                        @else
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{ __('tasks.task_name') }}</th>
                                    <th>{{ __('tasks.study_type') }}</th>
                                    <th>{{ __('tasks.applications') }}</th>
                                    <th>{{ __('tasks.accepted_student') }}</th>
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
                                        <td>{{ __('tasks.'.$task->tip_studija) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#applicationsModal{{ $task->id }}">
                                                {{ $task->prijavljeniStudenti->count() }} {{ __('tasks.applications') }}
                                            </button>
                                        </td>
                                        <td>
                                            @if($task->prihvaceniStudent)
                                                <span class="badge bg-success">{{ $task->prihvaceniStudent->name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>
                                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sigurno?')">
                                                    {{ __('messages.delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Modal za prijave -->
                                    <div class="modal fade" id="applicationsModal{{ $task->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('tasks.applied_students') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($task->prijavljeniStudenti->isEmpty())
                                                        <p class="text-muted">Nema prijava</p>
                                                    @else
                                                        <table class="table table-sm">
                                                            <thead>
                                                            <tr>
                                                                <th>Student</th>
                                                                <th>{{ __('tasks.priority') }}</th>
                                                                <th>{{ __('messages.actions') }}</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($task->prijavljeniStudenti as $student)
                                                                <tr>
                                                                    <td>{{ $student->name }}</td>
                                                                    <td>
                                                                    <span class="badge bg-{{ $student->pivot->prioritet == 1 ? 'success' : 'secondary' }}">
                                                                        {{ $student->pivot->prioritet }}
                                                                    </span>
                                                                    </td>
                                                                    <td>
                                                                        @if(!$task->prihvaceni_student_id)
                                                                            <form action="{{ route('tasks.accept', [$task, $student]) }}" method="POST">
                                                                                @csrf
                                                                                <button type="submit" class="btn btn-sm btn-success"
                                                                                    {{ $student->pivot->prioritet != 1 ? 'disabled' : '' }}>
                                                                                    {{ __('tasks.accept') }}
                                                                                </button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    @endif
                                                </div>
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

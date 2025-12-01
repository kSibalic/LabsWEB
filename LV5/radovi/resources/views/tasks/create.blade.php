@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('tasks.add_task') }}</div>

                    <div class="card-body">
                        <form action="{{ route('tasks.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">{{ __('tasks.task_name') }} (Hrvatski)</label>
                                <input type="text" name="naziv_rada" class="form-control @error('naziv_rada') is-invalid @enderror"
                                       value="{{ old('naziv_rada') }}" required>
                                @error('naziv_rada')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('tasks.task_name_en') }}</label>
                                <input type="text" name="naziv_rada_en" class="form-control @error('naziv_rada_en') is-invalid @enderror"
                                       value="{{ old('naziv_rada_en') }}" required>
                                @error('naziv_rada_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('tasks.task_description') }} (Hrvatski)</label>
                                <textarea name="zadatak_rada" rows="4" class="form-control @error('zadatak_rada') is-invalid @enderror" required>{{ old('zadatak_rada') }}</textarea>
                                @error('zadatak_rada')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('tasks.task_description_en') }}</label>
                                <textarea name="zadatak_rada_en" rows="4" class="form-control @error('zadatak_rada_en') is-invalid @enderror" required>{{ old('zadatak_rada_en') }}</textarea>
                                @error('zadatak_rada_en')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('tasks.study_type') }}</label>
                                <select name="tip_studija" class="form-select @error('tip_studija') is-invalid @enderror" required>
                                    <option value="">Odaberi...</option>
                                    <option value="stručni" {{ old('tip_studija') == 'stručni' ? 'selected' : '' }}>
                                        {{ __('tasks.strucni') }}
                                    </option>
                                    <option value="preddiplomski" {{ old('tip_studija') == 'preddiplomski' ? 'selected' : '' }}>
                                        {{ __('tasks.preddiplomski') }}
                                    </option>
                                    <option value="diplomski" {{ old('tip_studija') == 'diplomski' ? 'selected' : '' }}>
                                        {{ __('tasks.diplomski') }}
                                    </option>
                                </select>
                                @error('tip_studija')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
                                <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'New Task')

@section('content')
<div class="container" style="max-width:600px;">

    <div class="page-header">
        <div>
            <h1 class="page-title">New Task</h1>
            <p class="page-subtitle">Add a new task to your list</p>
        </div>
        <a href="{{ route('tasks.index') }}" class="btn btn-ghost">← Back</a>
    </div>

    <div class="card">

        @if ($errors->any())
            <div class="alert alert-error">
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin:0.4rem 0 0 1rem; font-size:0.875rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('tasks.store') }}">
            @csrf

            <div class="form-group">
                <label for="title">Title <span style="color:var(--red)">*</span></label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="What needs to be done?"
                    required
                    autofocus
                >
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea
                    id="description"
                    name="description"
                    placeholder="Add any additional details or notes…"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span style="color:var(--red)">*</span></label>
                <select id="status" name="status" required>
                    <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>
                        ⏳ Pending
                    </option>
                    <option value="done" {{ old('status') === 'done' ? 'selected' : '' }}>
                        ✅ Done
                    </option>
                </select>
                @error('status')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <hr class="divider">

            <div style="display:flex; gap:0.75rem; justify-content:flex-end;">
                <a href="{{ route('tasks.index') }}" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Create task
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

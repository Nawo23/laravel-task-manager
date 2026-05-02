@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
<div class="container" style="max-width:600px;">

    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Task</h1>
            <p class="page-subtitle">Update task details</p>
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

        <form method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title <span style="color:var(--red)">*</span></label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $task->title) }}"
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
                >{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span style="color:var(--red)">*</span></label>
                <select id="status" name="status" required>
                    <option value="pending" {{ old('status', $task->status) === 'pending' ? 'selected' : '' }}>
                        ⏳ Pending
                    </option>
                    <option value="done" {{ old('status', $task->status) === 'done' ? 'selected' : '' }}>
                        ✅ Done
                    </option>
                </select>
                @error('status')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <hr class="divider">

            <div style="display:flex; align-items:center; justify-content:space-between; gap:0.75rem;">
                {{-- Delete on the left --}}
                <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                      onsubmit="return confirm('Delete this task permanently?')" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                        Delete task
                    </button>
                </form>

                {{-- Save/cancel on the right --}}
                <div style="display:flex; gap:0.75rem;">
                    <a href="{{ route('tasks.index') }}" class="btn btn-ghost">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>

    <p style="color:var(--text-dim); font-size:0.8rem; text-align:center; margin-top:1rem;">
        Created {{ $task->created_at->format('M d, Y \a\t g:i A') }}
        &middot; Last updated {{ $task->updated_at->diffForHumans() }}
    </p>

</div>
@endsection

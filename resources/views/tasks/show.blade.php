@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="container" style="max-width:600px;">

    <div class="page-header">
        <div>
            <h1 class="page-title" style="word-break:break-word;">{{ $task->title }}</h1>
            <p class="page-subtitle">
                Created {{ $task->created_at->format('M d, Y') }}
            </p>
        </div>
        <a href="{{ route('tasks.index') }}" class="btn btn-ghost">← Back</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif

    <div class="card">

        {{-- Status badge + toggle --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.5rem;">
            <span class="badge badge-{{ $task->status }}" style="font-size:0.85rem; padding:0.35rem 0.85rem;">
                {{ $task->isDone() ? '✅ Done' : '⏳ Pending' }}
            </span>

            <form method="POST" action="{{ route('tasks.toggle', $task) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-ghost btn-sm">
                    {{ $task->isDone() ? 'Mark as pending' : 'Mark as done' }}
                </button>
            </form>
        </div>

        <hr class="divider" style="margin-top:0;">

        {{-- Description --}}
        <div style="margin-bottom:1.5rem;">
            <label style="margin-bottom:0.5rem;">Description</label>
            @if ($task->description)
                <p style="color:var(--text); line-height:1.7; white-space:pre-wrap;">{{ $task->description }}</p>
            @else
                <p style="color:var(--text-dim); font-style:italic;">No description provided.</p>
            @endif
        </div>

        <hr class="divider">

        {{-- Timestamps --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
            <div>
                <label style="margin-bottom:0.25rem;">Created</label>
                <p style="color:var(--text); font-size:0.9rem;">{{ $task->created_at->format('M d, Y g:i A') }}</p>
            </div>
            <div>
                <label style="margin-bottom:0.25rem;">Last updated</label>
                <p style="color:var(--text); font-size:0.9rem;">{{ $task->updated_at->diffForHumans() }}</p>
            </div>
        </div>

    </div>

    {{-- Action buttons --}}
    <div style="display:flex; gap:0.75rem; margin-top:1.25rem; justify-content:flex-end;">
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-ghost">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            Edit task
        </a>

        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
              onsubmit="return confirm('Delete this task permanently?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                Delete
            </button>
        </form>
    </div>

</div>
@endsection

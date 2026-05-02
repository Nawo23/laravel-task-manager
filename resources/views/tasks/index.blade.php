@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
<div class="container">

    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">My Tasks</h1>
            <p class="page-subtitle">
                {{ $counts['all'] }} total &middot;
                {{ $counts['pending'] }} pending &middot;
                {{ $counts['done'] }} done
            </p>
        </div>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New task
        </a>
    </div>

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="alert alert-success">✓ {{ session('success') }}</div>
    @endif

    {{-- Filter Tabs --}}
    <div style="display:flex; gap:0.5rem; margin-bottom:1.75rem; border-bottom:1px solid var(--border); padding-bottom:0;">
        @foreach (['all' => 'All', 'pending' => 'Pending', 'done' => 'Done'] as $key => $label)
            @php
                $isActive = request('status', 'all') === $key;
                $url = $key === 'all' ? route('tasks.index') : route('tasks.index', ['status' => $key]);
            @endphp
            <a href="{{ $url }}"
               style="display:inline-block; padding:0.5rem 1rem; font-size:0.875rem; font-weight:500; text-decoration:none; border-bottom:2px solid {{ $isActive ? 'var(--accent)' : 'transparent' }}; color:{{ $isActive ? 'var(--accent)' : 'var(--text-muted)' }}; margin-bottom:-1px; transition:color 0.15s ease;">
                {{ $label }}
                <span style="margin-left:0.3rem; font-size:0.75rem; opacity:0.7;">({{ $counts[$key] ?? $counts['all'] }})</span>
            </a>
        @endforeach
    </div>

    {{-- Task List --}}
    @if ($tasks->isEmpty())
        <div class="empty-state">
            <div class="empty-state-icon">📋</div>
            <h3>No tasks yet</h3>
            <p>
                @if (request('status'))
                    No {{ request('status') }} tasks found.
                @else
                    Create your first task to get started.
                @endif
            </p>
            <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create a task</a>
        </div>
    @else
        <div style="display:flex; flex-direction:column; gap:0.75rem;">
            @foreach ($tasks as $task)
                <div style="background:var(--bg-card); border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.25rem 1.5rem; display:flex; align-items:center; gap:1rem; transition:border-color 0.15s ease; {{ $task->isDone() ? 'opacity:0.65;' : '' }}"
                     onmouseover="this.style.borderColor='var(--border-light)'"
                     onmouseout="this.style.borderColor='var(--border)'">

                    {{-- Toggle checkbox --}}
                    <form method="POST" action="{{ route('tasks.toggle', $task) }}" style="flex-shrink:0;">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                title="{{ $task->isDone() ? 'Mark as pending' : 'Mark as done' }}"
                                style="width:22px; height:22px; border-radius:6px; border:2px solid {{ $task->isDone() ? 'var(--green)' : 'var(--border-light)' }}; background:{{ $task->isDone() ? 'var(--green)' : 'transparent' }}; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all 0.15s ease;">
                            @if ($task->isDone())
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#0f0f11" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                            @endif
                        </button>
                    </form>

                    {{-- Task content --}}
                    <div style="flex:1; min-width:0;">
                        <a href="{{ route('tasks.show', $task) }}"
                           style="font-weight:500; font-size:0.975rem; color:var(--text); text-decoration:none; display:block; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; {{ $task->isDone() ? 'text-decoration:line-through; color:var(--text-muted);' : '' }}">
                            {{ $task->title }}
                        </a>
                        @if ($task->description)
                            <p style="font-size:0.82rem; color:var(--text-muted); margin-top:0.2rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                {{ $task->description }}
                            </p>
                        @endif
                    </div>

                    {{-- Meta --}}
                    <div style="display:flex; align-items:center; gap:0.75rem; flex-shrink:0;">
                        <span class="badge badge-{{ $task->status }}">
                            {{ ucfirst($task->status) }}
                        </span>
                        <span style="font-size:0.78rem; color:var(--text-dim);">
                            {{ $task->created_at->format('M d') }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div style="display:flex; gap:0.4rem; flex-shrink:0;">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-ghost btn-sm" title="Edit">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>

                        <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                              onsubmit="return confirm('Delete this task? This cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if ($tasks->hasPages())
            <div style="margin-top:2rem;">
                {{ $tasks->links('tasks.pagination') }}
            </div>
        @endif
    @endif

</div>
@endsection

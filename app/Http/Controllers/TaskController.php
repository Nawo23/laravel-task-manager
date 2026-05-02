<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the authenticated user's tasks.
     */
    public function index(Request $request)
    {
        $query = Task::forUser(Auth::id())->latest();

        // Filter by status if provided
        if ($request->filled('status') && in_array($request->status, ['pending', 'done'])) {
            $query->withStatus($request->status);
        }

        $tasks  = $query->paginate(10)->withQueryString();
        $counts = [
            'all'     => Task::forUser(Auth::id())->count(),
            'pending' => Task::forUser(Auth::id())->withStatus('pending')->count(),
            'done'    => Task::forUser(Auth::id())->withStatus('done')->count(),
        ];

        return view('tasks.index', compact('tasks', 'counts'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        Auth::user()->tasks()->create($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $this->authorizeTask($task);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $this->authorizeTask($task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorizeTask($task);

        $task->update($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }

    /**
     * Toggle task status between pending and done.
     */
    public function toggle(Task $task)
    {
        $this->authorizeTask($task);

        $task->update([
            'status' => $task->isDone() ? Task::STATUS_PENDING : Task::STATUS_DONE,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Task status updated!');
    }

    /**
     * Ensure the authenticated user owns the task.
     * Abort with 403 if they don't.
     */
    private function authorizeTask(Task $task): void
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to access this task.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Auth::user()->tasks()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'required_without' => 'Title or description is required.',
        ]);

        // Custom validation: at least title or description must be provided
        if (empty($request->title) && empty($request->description)) {
            return back()->withErrors([
                'title' => 'Title or description is required.'
            ])->withInput();
        }

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id(),
            'status' => 'in_progress',
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:in_progress,finished',
        ]);

        // Custom validation: at least title or description must be provided
        if (empty($request->title) && empty($request->description)) {
            return back()->withErrors([
                'title' => 'Title or description is required.'
            ])->withInput();
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Update only the status of the specified task.
     */
    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'status' => 'required|in:in_progress,finished',
        ]);

        $task->update([
            'status' => $request->status,
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Task status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }
}

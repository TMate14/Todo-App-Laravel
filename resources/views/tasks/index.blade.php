@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
    <div class="mb-3">
        <a href="{{ route('tasks.create') }}" class="add-task-btn">
            Add New Task
        </a>
    </div>

    @if($tasks->count() > 0)
        @foreach($tasks as $task)
            <div class="task-item">
                <div class="task-header">
                    <h3 class="task-title">
                        {{ $task->title ?: 'Untitled Task' }}
                    </h3>
                    <span class="task-status {{ $task->status === 'finished' ? 'status-finished' : 'status-in-progress' }}">
                        {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                    </span>
                </div>

                @if($task->description)
                    <p class="task-description">
                        {{ Str::limit($task->description, 150) }}
                    </p>
                @endif

                <div class="task-actions">
                    <a href="{{ route('tasks.edit', $task) }}" class="btn-secondary">Edit</a>

                    @if($task->status === 'in_progress')
                        <form method="POST" action="{{ route('tasks.updateStatus', $task) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="finished">
                            <button type="submit" class="btn-success">Mark as Finished</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('tasks.updateStatus', $task) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit" class="btn-warning">Mark as In Progress</button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('tasks.destroy', $task) }}"
                        onsubmit="return confirm('Are you sure you want to delete this task?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">Delete</button>
                    </form>
                </div>

                <small class="task-meta">
                    Created: {{ $task->created_at->format('M j, Y g:i A') }}
                    @if($task->updated_at->ne($task->created_at))
                        | Updated: {{ $task->updated_at->format('M j, Y g:i A') }}
                    @endif
                </small>
            </div>
        @endforeach
    @else
        <div class="empty-state">
            <h3>No tasks yet!</h3>
            <p>Create your first task to get started.</p>
            <a href="{{ route('tasks.create') }}" class="add-task-btn">
                Add Your First Task
            </a>
        </div>
    @endif
@endsection
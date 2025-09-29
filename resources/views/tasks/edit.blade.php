@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <form method="POST" action="{{ route('tasks.update', $task) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $task->title) }}"
                placeholder="Enter task title (optional)">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"
                placeholder="Enter task description (optional)">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="in_progress" {{ old('status', $task->status) === 'in_progress' ? 'selected' : '' }}>
                    In Progress
                </option>
                <option value="finished" {{ old('status', $task->status) === 'finished' ? 'selected' : '' }}>
                    Finished
                </option>
            </select>
        </div>

        <p class="note-text">
            Note: Either title or description is required.
        </p>

        <div class="form-group">
            <button type="submit">Update Task</button>
            <a href="{{ route('tasks.index') }}" class="btn-secondary ml-2">Cancel</a>
        </div>
    </form>

    <div class="task-info">
        <h4>Task Information</h4>
        <p><strong>Created:</strong> {{ $task->created_at->format('M j, Y g:i A') }}</p>
        <p><strong>Last Updated:</strong> {{ $task->updated_at->format('M j, Y g:i A') }}</p>
    </div>
@endsection
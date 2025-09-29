@extends('layouts.app')

@section('title', 'Create New Task')

@section('content')
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf

        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Enter task title (optional)">
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"
                placeholder="Enter task description (optional)">{{ old('description') }}</textarea>
        </div>

        <p class="note-text">
            Note: Either title or description is required.
        </p>

        <div class="form-group">
            <button type="submit">Create Task</button>
            <a href="{{ route('tasks.index') }}" class="btn-secondary ml-2">Cancel</a>
        </div>
    </form>
@endsection
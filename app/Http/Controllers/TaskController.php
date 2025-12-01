<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    //Get all tasks of user
    public function index()
    { 
        $tasks = auth()->user()->tasks()
                        ->latest()
                        ->get();

        //Render the Vue component and pass the tasks as an Inertia prop.
        return Inertia::render('Tasks/TaskIndex', [
            'tasks' => $tasks,
        ]);
    }

    //add task
    public function store(Request $request)
    {
        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // 2. Create the task, automatically linking it to the authenticated user.
        auth()->user()->tasks()->create($validatedData);

        // 3. Redirect back to the task list with a success flash message.
        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    //update task
    public function update(Request $request, Task $task)
    {
        // 1. Ensure the authenticated user owns this task (Authorization).
        // This is a basic authorization check. You can use a dedicated Policy later.
        if ($request->user()->id !== $task->user_id) {
            abort(403);
        }

        // 2. Validate and update
        $validatedData = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_completed' => ['required', 'boolean'],
        ]);
        
        $task->update($validatedData);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    //remove task
    public function destroy(Task $task)
    {
        // 1. Ensure the authenticated user owns this task (Authorization).
        if (auth()->id() !== $task->user_id) {
            abort(403);
        }
        
        // 2. Delete the task
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task removed successfully.');
    }
}
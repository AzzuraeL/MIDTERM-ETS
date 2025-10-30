<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Project $project)
    {
        
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $tasks = $project->tasks;
        return view('tasks.index', compact('project', 'tasks'));
    }

    public function create(Project $project)
    {
        
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('tasks.create', compact('project'));
    }

    public function store(Request $request, Project $project)
    {
        
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        $project->tasks()->create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('tasks.index', $project)->with('success', 'Task created successfully!');
    }

    public function edit(Task $task)
    {
        
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index', $task->project)->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        $project = $task->project;
        $task->delete();

        return redirect()->route('tasks.index', $project)->with('success', 'Task deleted successfully!');
    }

    public function toggleStatus(Task $task)
    {
        
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        
        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';
        $task->update(['status' => $newStatus]);

        
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'completed' => $newStatus === 'completed',
                'status' => $newStatus,
                'message' => 'Task status updated!'
            ]);
        }

        return redirect()->back()->with('success', 'Task status updated!');
    }
}

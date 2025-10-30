<?php

namespace App\Http\Controllers;

use App\Models\ChecklistItem;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChecklistItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Task $task)
    {
        // Check if the task belongs to the authenticated user
        if ($task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task->checklistItems()->create($validated);

        return redirect()->route('tasks.edit', $task)->with('success', 'Checklist item added!');
    }    public function toggle(ChecklistItem $checklistItem)
    {
        // Check if the task belongs to the authenticated user
        if ($checklistItem->task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $checklistItem->update([
            'completed' => !$checklistItem->completed,
        ]);

        // Return JSON for AJAX requests
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'completed' => $checklistItem->completed,
                'message' => 'Checklist item updated!'
            ]);
        }

        return redirect()->back()->with('success', 'Checklist item updated!');
    }

    public function destroy(ChecklistItem $checklistItem)
    {
        // Check if the task belongs to the authenticated user
        if ($checklistItem->task->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $task = $checklistItem->task;
        $checklistItem->delete();

        return redirect()->route('tasks.edit', $task)->with('success', 'Checklist item deleted!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('userName')->orderBy('id', 'DESC')->get();
        return view('task.index',['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $html = view('task.create-edit-modal')->render();
        return response()->json([
            'status' => true,
            'message' => 'Form recieved successfully',
            'html' => $html
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required'],
            'status' => ['required'],
        ]);
        
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => Auth::user()->id
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Task Created successfully',
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        try {
            $html = view('tassk.modal-data',['task' => $task])->render();
            return response()->json([
                'status' => true,
                'message' => 'Task recieved successfully',
                'data' =>  $task
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        try {
            $html = view('task.create-edit-modal',['task' => $task])->render();
            return response()->json([
                'status' => true,
                'message' => 'Task recieved successfully',
                'fromUri' => route('tasks.update', $task->id),
                'html' =>  $html
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $task->user_id = Auth::user()->id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();
        return response()->json([
            'status' => true,
            'message' => 'Task '. $task->title .' updated successfully',
            'data' =>  $task,
        ], 200);

       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json([
            'status' => true,
            'message' => 'Task deleted successfully',
        ], 200);
    }
}

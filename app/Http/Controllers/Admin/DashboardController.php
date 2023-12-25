<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        $tasks = Task::with('userName')->orderBy('id', 'DESC')->get();
        return view('admin.dashboard',['tasks' => $tasks]);
    }
}

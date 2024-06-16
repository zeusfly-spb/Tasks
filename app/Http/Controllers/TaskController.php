<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @param Request $request
     * @return TaskResource
     */
    public function store(Request $request): TaskResource
    {
        return response()->json(new TaskResource(Task::create($request->all())));
    }
}

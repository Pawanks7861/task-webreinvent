<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('tasks');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'task' => 'required|unique:tasks,title',
        ]);

        $task = Task::create(['title' => $request->task]);

        return response()->json($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $data = [];
        $start = (int)$request->get('start');
        $limit = (int)$request->get('length');

        $draw = $request->get('draw');  // Capture the draw parameter
        $tasks = Task::query();
        $total = $tasks->count();
        $tasks = Task::query();

        $tasks = $tasks
            ->skip($start)
            ->take($limit)
            ->get()
            ->toArray();

        foreach ($tasks as $tasks) {
            $action = '<td>';
            if ($tasks['is_completed'] == 0) {
                $action .= '<button  id="complete-' . $tasks['id'] . '" class="btn btn-success mark-complete" data-id="' . $tasks['id'] . '">✔</button>';
            }


            $action .= '<button class="btn btn-danger deleteTask" data-id="' . $tasks['id'] . '">✖</button>
            </td>';
            $row = [];
            $row[] = ++$start;
            $row[] = $tasks['title'];
            $row[] = $tasks['is_completed'] == 1 ? 'Done' : 'Pending';
            $row[] = $action;
            $data[] = $row;
        }
        $output = [
            "draw" => intval($draw),  // Return the draw parameter
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data,
        ];

        return response()->json($output);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $task)
    {
        $task = Task::findOrFail($task);
        $task->is_completed = $task->is_completed == 0 ? 1 : 0;
        $task->save();

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($task)
    {
        $task = Task::findOrFail($task);
        $task->delete();

        return response()->json(['success' => true]);
    }
}

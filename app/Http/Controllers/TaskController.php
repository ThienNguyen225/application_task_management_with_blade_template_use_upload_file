<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('index', compact('tasks'));
    }

    public function creat()
    {
        return view('add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $task = new Task();
        $task->title = $request->input('inputTitle');
        $task->content = $request->input('inputContent');
        $task->due_date = $request->input('inputDueDate');

        if (isset($request->inputFile)) {
            $image = $request->inputFile;
            $path = $image->store('images', 'public');
            $task->image = $path;
        } else {
            echo "anh nay khong co";
        }

        $task->save();
        $message = "Tạo Task $request->inputTitle thành công!";
        Session::flash('create-success', $message);
        return redirect()->route('tasks.index', compact('message'));
    }
}

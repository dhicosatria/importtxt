<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Todos;
use App\Http\Resources\FormatPostResource;

class TodoController extends Controller
{
    public function showTodo()
    {
        $data_todo = Todos::get();

        return [
            'data_todo' => $data_todo,
        ];
    }

    public function createTodo(Request $request)
    {
        $receive = Todos::create([
            'title' => $request->title,
            'checked' => 0,
        ]);
    }

    public function deleteTodo($id)
    {
        $data_todo = Todos::findOrFail($id);
        $data_todo->delete();
    }

    public function checkTodo(Request $request, $id)
    {
        $data_todo = Todos::findOrFail($id);
      
        $data_todo->update([
            'checked' => $request->check,
        ]);
    }
}

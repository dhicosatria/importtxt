<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ClientTodoController extends Controller
{
    public function showTodo()
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer',
                'Accept' => 'application/json',
            ],
        ]);

        $response = $client->request('GET', 'http://localhost/betodo/public/api/');
        $statusCode = $response->getStatusCode();
        $body = $response->getBody();

        $data = json_decode($body);
        

        return view('index', [
            'data_todo' => $data->data_todo,
        ]);
    }

    public function createTodo(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer',
                'Accept' => 'application/json',
            ],
        ]);
        
        $response = $client->request('POST', 'http://localhost/betodo/public/api/add-todo',
        [
            'json' => [
                'title' => $request->title,
            ]
        ]
        );

        return redirect('/');
    }

    public function deleteTodo($id)
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer',
                'Accept' => 'application/json',
            ],
        ]);
        
        $response = $client->request('DELETE', 'http://localhost/betodo/public/api/delete-todo/'.$id);

        return redirect('/');
    }    

    public function checkTodo(Request $request, $id)
    {
        $client = new Client([
            'headers' => [
                'Authorization' => 'Bearer',
                'Accept' => 'application/json',
            ],
        ]);
        
        $response = $client->request('PUT', 'http://localhost/betodo/public/api/check-todo/'.$id,
        [
            'json' => [
                'check' => $request->check,
            ]
        ]
        );

        return redirect('/');
    }
}

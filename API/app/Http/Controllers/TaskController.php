<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Task;

class TaskController extends Controller
{
    private $json = [
        'data' => [],
        'errors' => [],
        'status' => true
    ];

    public function find($id)
    {
        try {

            $task = Task::find($id);
            $duties = $task->duties;
            
            foreach($duties as $duty) {
                $duty->user;
            }

            $this->json['data'] = [
                'task' => $task
            ];

            $code = 200;

        } catch (\Exception $e) {

            $this->json['errors'] = [
                'main' => $e->getMessage()
            ];
            $this->json['status'] = false;

            $code = 500;

        }

        return response()->json($this->json, $code);
    }

    public function get()
    {
        try {

            $this->json['data'] = Task::orderBy('created_at', 'DESC')->get();

            $code = 200;

        } catch (\Exception $e) {

            $this->json['errors'] = [
                'main' => $e->getMessage()
            ];
            $this->json['status'] = false;

            $code = 500;

        }

        $this->json['status'] = true;
        return response()->json($this->json, $code);
    }

    public function post(Request $req)
    {
        $validated = Validator::make($req->all(), [
            'task' => 'required|min:3|max:100',
            'description' => 'required',
            'points' => 'integer|required'
        ]);

        if($validated->fails()) {
            $this->json['data'] = $req->all();
            $this->json['errors'] = $validated->errors();
            $this->json['status'] = false;

            return response()->json($this->json, 400);
        }

        try {

            $task = new Task;
            $task->task = $req->task;
            $task->description = $req->description;
            $task->points = (int) $req->points;
            $task->save();

            $this->json['data'] = $task;
            $this->json['status'] = true;

            $code = 200;

        } catch (\Exception $e) {

            $this->json['errors'] = [
                'main' => $e->getMessage()
            ];                        
            $this->json['status'] = false;

            $code = 400;

        }

        return response()->json($this->json, $code);
    }

    public function put($id, Request $req)
    {
        $validated = Validator::make($req->all(), [
            'task' => 'required|min:3|max:100',
            'description' => 'required',
            'points' => 'integer|required'
        ]);

        if($validated->fails()) {
            $this->json['data'] = $req->all();
            $this->json['errors'] = $validated->errors();
            $this->json['status'] = false;

            return response()->json($this->json, 400);
        }

        try {

            $task = Task::find($id);
            $task->task = $req->task;
            $task->description = $req->description;
            $task->points = (int) $req->points;
            $task->save();

            $this->json['data'] = $task;
            $this->json['status'] = true;

            $code = 200;

        } catch (\Exception $e) {

            $this->json['errors'] = [
                'main' => $e->getMessage()
            ];                        
            $this->json['status'] = false;

            $code = 400;            

        }

        return response()->json($this->json, $code);
    }

    public function delete($id)
    {
        try {

            Task::destroy($id);

            $this->json['data'] = [
                'id' => $id
            ];
            $this->json['status'] = true;

            $code = 200;

        } catch (\Exception $e) {

            $this->json['errors'] = [
                'main' => $e->getMessage()
            ];                        
            $this->json['status'] = false;

            $code = 400;  

        }
        
        return response()->json($this->json, $code);
    }
}

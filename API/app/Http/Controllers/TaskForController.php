<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskFor;

use Illuminate\Support\Facades\Validator;

class TaskForController extends Controller
{
    private $json = [
        'data' => [],
        'errors' => [],
        'status' => true
    ];

    // For Admin
    public function post(Request $req)
    {
        $validated = Validator::make($req->all(), [
            'user_id' => 'required|integer',
            'task_id' => 'required|integer',            
        ]);

        if($validated->fails()) {
            $this->json['data'] = $req->all();
            $this->json['errors'] = $validated->errors();
            $this->json['status'] = false;

            return response()->json($this->json, 400);
        }        

        try {

            $taskFor = new TaskFor();
            $taskFor->user_id = $req->user_id;
            $taskFor->task_id = $req->task_id;
            $taskFor->finished = 0;
            $taskFor->save();

            $this->json['data'] = $taskFor;
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

    // For Client
    public function finish($id)
    {
        try {

            $taskFor = TaskFor::findOrFail($id);

            if(!$taskFor->active) {
                throw new \Exception("Task is not active");
            }

            if(!$taskFor->user->id != Auth::guard()->user()->id) {
                throw new \Exception("Unknown User");
            }

            $taskFor->finish = $taskFor->finish;
            $taskFor->save();

            $this->json['data'] = $taskFor;
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

    // For Admin
    public function toggleActive($id)
    {
        try {

            $taskFor = TaskFor::findOrFail($id);
            $taskFor->active = !$taskFor->active;
            $taskFor->save();

            $this->json['data'] = $taskFor;
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

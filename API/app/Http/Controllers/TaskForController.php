<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaskFor;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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

            if(!$taskFor->user->id == Auth::guard()->user()->id) {
                throw new \Exception("Unknown User ");
            }

            $taskFor->finished = 1;
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
    public function delete($id)
    {
        try {

            if(!$taskFor = TaskFor::findOrFail($id)) {
                throw new \Exception("Not Found Item");
            }
            $taskFor->delete();

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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class UserController extends Controller
{
    private $json = [
        'data' => [],
        'errors' => [],
        'status' => true
    ];

    public function get()
    {
        try {

            $this->json['data'] = User::orderBy('created_at')->get();

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

    public function find($id)
    {
        try {

            $user = User::findOrFail($id);
            $user->level;
            $user->role;
            $user->duties;
            $user->logs;

            $this->json['data'] = $user;

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

    public function delete($id)
    {
        try {

            if($id < 3) {
                throw new \Exception("Restricted id to update/delete[$id]");
            }

            if(!$user = User::findOrFail($id)) {
                throw new \Exception("Not Found Item");
            }
            $user->delete();

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

    public function changeRole($id, Request $req)
    {
        $validated = Validator::make($req->all(), [
            'role_id' => 'required|integer'
        ]);

        if($validated->fails()) {
            $this->json['data'] = $req->all();
            $this->json['errors'] = $validated->errors();
            $this->json['status'] = false;

            return response()->json($this->json);
        }

        try {

            if($id < 3) {
                throw new \Exception("Restricted id to update/delete[$id]");
            }

            $user = User::findOrFail($id);
            $user->role_id = $req->role_id;
            $user->save();

            $this->json['data'] = $user;

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

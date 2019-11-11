<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    private $json = [
        'data' => [],
        'errors' => [],
        'status' => true
    ];

    public function post(Request $req)
    {
        $validated = Validator::make($req->all(), [
            'role' => 'required|min:3|max:100|unique:roles',
        ]);

        if($validated->fails()) {
            $this->json['data'] = $req->all();
            $this->json['errors'] = $validated->errors();
            $this->json['status'] = false;

            return response()->json($this->json, 400);
        }

        try {

            $role = new Role;
            $role->role = $req->role;
            $role->save();

            $this->json['data'] = $role;
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

    public function find($id)
    {
        try {

            $role = Role::findOrFail($id);                                   

            foreach($role->permissions as $permission) {
                $permission->feature;
            }

            $role->users;

            $this->json['data'] = [
                'role' => $role
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

            $this->json['data'] = Role::orderBy('created_at', 'DESC')->get();

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

    public function put($id, Request $req)
    {
        $validated = Validator::make($req->all(), [
            'role' => 'required|min:3|max:100|unique:roles',
        ]);

        if($validated->fails()) {
            $this->json['data'] = $req->all();
            $this->json['errors'] = $validated->errors();
            $this->json['status'] = false;

            return response()->json($this->json, 400);
        }

        try {

            if($id < 3) {
                throw new \Exception("Restricted id to update/delete[$id]");
            }

            $role = Role::findOrFail($id);
            $role->role = $req->role;
            $role->save();

            $this->json['data'] = $role;
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

            if($id < 3) {
                throw new \Exception("Restricted id to update/delete[$id]");
            }

            if(!$role = Role::findOrFail($id)) {
                throw new \Exception("Not Found Item");
            }
            $role->delete();

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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Permission;

class PermissionController extends Controller
{
    private $json = [
        'data' => [],
        'errors' => [],
        'status' => true
    ];

    public function post(Request $req)
    {
        $validated = Validator::make($req->all(), [
            'role_id' => 'required|integer',
            'feature_id' => 'required|integer'
        ]);

        if($validated->fails()) {
            $this->json['data'] = $req->all();
            $this->json['errors'] = $validated->errors();
            $this->json['status'] = false;

            return response()->json($this->json, 400);
        }

        try {

            $permission = new Permission();
            $permission->role_id = $req->role_id;
            $permission->feature_id = $req->feature_id;
            $permission->active = 1;
            $permission->save();

            $this->json['data'] = $permission;
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

    public function toggle($id)
    {
        try {

            $permission = Permission::findOrFail($id);

            if($permission->role_id == 1) {
                throw new \Exception("Restricted id [$id]");
            }

            $permission->active = !$permission->active;
            $permission->save();

            $this->json['data'] = $permission;
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

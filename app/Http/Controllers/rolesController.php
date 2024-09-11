<?php

namespace App\Http\Controllers;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class rolesController extends Controller
{
    public function index() {
        $roles = Roles::all();
        
        if ($roles->isEmpty()) {
            $data = [
                'message' => 'No se encontraron roles',
                'status' => 200
            ];
            
            return response()->json($data, 200);
        }

        return response()->json($roles, 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),  [
            'role' => 'required|max:20',
            'isActive' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $roles = Roles::create([
            'role' => $request->role,
            'isActive' => $request->isActive
        ]);

        if (!$roles) {
            $data = [
                'message' => 'Error al crear el rol',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'roles' => $roles,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id) {
        $roles = Roles::find($id);
        
        if (!$roles) {
            $data = [
                'message' => 'Rol no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'role' => $roles,
            'status' => 200
        ];
    
        return response()->json($data, 200);
    }

    public function destroy($id) {

        $roles = Roles::find($id);

        if (!$roles) {
            $data =  [
                'message' => 'role no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $roles->delete();

        $data = [
            'message' => 'role eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id) {
        $roles = Roles::find($id);

        if (!$roles) {
            $data = [
                'message' => 'Role no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'role' => 'required|max:20',
            'isActive' => 'required'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $roles->role = $request->role;
        $roles->isActive = $request->isActive;

        $roles->save();

        $data = [
            'message' => 'Role actualizado',
            'roles' => $roles,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id) {
        $roles = Roles::find($id);

        if (!$roles) {
            $data = [
                'message' => 'Role no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'role' => 'max:20'
        ]);
        
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('role')) {
            $roles->role = $request->role;
        }

        if ($request->has('isActive')) {
            $roles->isActive = $request->isActive;
        }

        $roles->save();

        $data = [
            'message' => 'Role actualzado',
            'role' => $roles,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class usersController extends Controller
{
    public function index() {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        $users = Users::all()->makeHidden(['password']);
        
        if ($users->isEmpty()) {
            $data = [
                'message' => 'No se encontraron usuarios',
                'status' => 200
            ];
            
            return response()->json($data, 200);
        }

        return response()->json($users, 200);
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),  [
            'firstname' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'isActive' => 'required|boolean',
            'roleId' => 'required|int'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $users = Users::create([
            'firstname' => $request->firstname,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => $request->password,
            'isActive' => $request->isActive,
            'roleId' => $request->roleId
        ]);

        if (!$users) {
            $data = [
                'message' => 'Error al crear el usuario',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'users' => $users,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function show($id) {
        $users = Users::find($id)->makeHidden(['password']);;
        
        if (!$users) {
            $data = [
                'message' => 'usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'users' => $users,
            'status' => 200
        ];
    
        return response()->json($data, 200);
    }

    public function destroy($id) {

        $users = Users::find($id);

        if (!$users) {
            $data =  [
                'message' => 'usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $users->isActive = false;

        $users->save();

        $data = [
            'message' => 'usuario eliminado',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id) {
        $users = Users::find($id);

        if (!$users) {
            $data = [
                'message' => 'usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'isActive' => 'required|boolean',
            'roleId' => 'requited|int'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $users->firstname = $request->firstname;
        $users->surname = $request->surname;
        $users->email = $request->email;
        $users->password = $request->password;
        $users->isActive = $request->isActive;

        $users->save();

        $data = [
            'message' => 'usuario actualizado',
            'user' => $users,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id) {
        $users = Users::find($id);

        if (!$users) {
            $data = [
                'message' => 'usuario no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'firstname' => '',
            'surname' => '',
            'email' => 'email',
            'password' => '',
            'isActive' => 'boolean',
            'roleId' => 'int'
        ]);
        
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('firstname')) {
            $users->firstname = $request->firstname;
        }

        if ($request->has('surname')) {
            $users->surname = $request->surname;
        }

        if ($request->has('email')) {
            $users->email = $request->email;
        }

        if ($request->has('password')) {
            $users->password = $request->password;
        }

        if ($request->has('isActive')) {
            $users->isActive = $request->isActive;
        }

        if ($request->has('roleId')) {
            $users->roleId = $request->roleId;
        }

        $users->save();

        $data = [
            'message' => 'usuario actualzado',
            'users' => $users,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

}

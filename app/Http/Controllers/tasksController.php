<?php

namespace App\Http\Controllers;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class tasksController extends Controller
{
    public function index(Request $request) {
       
        $perPage = $request->input('per_page', 10);

        $query = Tasks::query()->where('isActive', '=', 1);

        $tasks = $query->get()->paginate($perPage);
        
        if ($tasks->isEmpty()) {
            $data = [
                'message' => 'No se encontraron tareas',
                'status' => 200
            ];
            
            return response()->json($data, 200);
        }

        return response()->json($tasks, 200);
    }

    public function search(Request $request) {
        
        $title = $request->input('title');
        $description = $request->input('description');
        $isComplete = $request->input('isComplete');

        $query = Tasks::query();

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if ($description) {
            $query->where('description', 'like', '%' . $description . '%');
        }

        if ($isComplete) {
            $query->where('isComplete', '=', $isComplete);
        }

        $tasks = $query->get();

        if ($tasks->isEmpty()) {
            $data = [
                'message' => 'No se encontraron tareas',
                'status' => 200
            ];
            
            return response()->json($data, 200);
        }

        return response()->json($tasks, 200);
    }

    public function store(Request $request) {
        
        $validator = Validator::make($request->all(),  [
            'title' => 'required',
            'description' => 'required',
            'expirationDate' => 'required|date',
            'isActive' => 'required|boolean',
            'isComplete' => 'required|boolean',
            'userCreateId' => 'required|int',
            'userAssignId' => 'required|int'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $tasks = Tasks::create([
            'title' => $request->title,
            'description' => $request->description,
            'expirationDate' => $request->expirationDate,
            'isActive' => $request->isActive,
            'isComplete' => $request->isComplete,
            'userCreateId' => $request->userCreateId,
            'userAssignId' => $request->userAssignId
        ]);

        if (!$tasks) {
            $data = [
                'message' => 'Error al crear la tarea',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'tasks' => $tasks,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function destroy($id) {
        $tasks = Tasks::find($id);

        if (!$tasks) {
            $data =  [
                'message' => 'role no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $tasks->delete();

        $data = [
            'message' => 'tarea eliminada',
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function update(Request $request, $id) {
        $tasks = Tasks::find($id);

        if (!$tasks) {
            $data = [
                'message' => 'tarea no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(),  [
            'title' => 'required',
            'description' => 'required',
            'expirationDate' => 'required|date',
            'isActive' => 'required|boolean',
            'isComplete' => 'required|boolean',
            'userCreateId' => 'required|int',
            'userAssignId' => 'required|int'
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $tasks->title = $request->title;
        $tasks->description = $request->description;
        $tasks->expirationDate = $request->expirationDate;
        $tasks->isActive = $request->isActive;
        $tasks->isComplete = $request->isComplete;
        $tasks->userCreateId = $request->userCreateId;
        $tasks->userAssignId = $request->userAssignId;

        $tasks->save();

        $data = [
            'message' => 'tarea actualizada',
            'task' => $tasks,
            'status' => 201
        ];
        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id) {
        $tasks = Tasks::find($id);

        if (!$tasks) {
            $data = [
                'message' => 'tarea no encontrada',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => '',
            'description' => '',
            'expirationDate' => 'date',
            'isActive' => 'boolean',
            'isComplete' => 'boolean',
            'userId' => 'int'
        ]);
        
        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        if ($request->has('title')) {
            $tasks->title = $request->title;
        }

        if ($request->has('description')) {
            $tasks->description = $request->description;
        }

        if ($request->has('expirationDate')) {
            $tasks->expirationDate = $request->expirationDate;
        }

        if ($request->has('isActive')) {
            $tasks->isActive = $request->isActive;
        }

        if ($request->has('isComplete')) {
            $tasks->isComplete = $request->isComplete;
        }

        if ($request->has('userId')) {
            $tasks->userId = $request->userId;
        }

        $tasks->save();

        $data = [
            'message' => 'tarea actualzada',
            'task' => $tasks,
            'status' => 200
        ];
        return response()->json($data, 200);
    }
}

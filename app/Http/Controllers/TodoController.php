<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        try {
            $todos = Todo::all();
            return response()->json(['todos' => $todos]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $todo = Todo::create([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            return response()->json(['todo' => $todo], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            return response()->json(['todo' => $todo]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $todo = Todo::findOrFail($id);

            $todo->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            return response()->json(['todo' => $todo]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            $todo->delete();

            return response()->json(['message' => 'Todo deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}

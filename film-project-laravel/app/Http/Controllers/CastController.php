<?php

namespace App\Http\Controllers;

use App\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CastController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cast = Cast::latest()->get();

        $total = count($cast);

        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table cast berhasil ditampilkan',
            'total' => $total,
            'data'    => $cast
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'age' => 'required|numeric|digits:2'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = auth()->user();

        if ($user->role->name != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan admin!'
            ], 403);
        }

        $cast = Cast::create([
            'name'  => $request->name,
            'age' => $request->age,
            'bio' => $request->bio
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Cast is added successfully',
            'data'    => $cast
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cast  $cast
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cast = Cast::find($id);

        if ($cast) {
            return response()->json([
                'success' => true,
                'message' => 'Get Detail Cast',
                'data'    => $cast
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data dengan id : ' . $id . ' tidak ditemukan'
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cast  $cast
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'age' => 'numeric|digits:2'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $cast = Cast::find($id);

        $user = auth()->user();

        if ($user->role->name != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan admin!'
            ], 403);
        }

        $cast->update([
            'name'  => $request->name ?? $cast->name,
            'age' => $request->age ?? $cast->age,
            'bio' => $request->bio ?? $cast->bio
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Cast is update successfully',
            'data'    => $cast
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cast  $cast
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cast = Cast::find($id);

        $user = auth()->user();

        if ($user->role->name != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan admin!'
            ], 403);
        }

        $cast->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cast is delete successfully',
            'data'    => $cast
        ], 200);
    }

    public function search($name)
    {
        $cast = Cast::where('name', 'like', '%' . $name . '%')->get();

        $total = count($cast);

        if ($total) {
            $data = [
                'message' => 'Get searched resource',
                'total' => $total,
                'data' => $cast
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Resource not found'
            ];

            return response()->json($data, 404);
        }
    }
}

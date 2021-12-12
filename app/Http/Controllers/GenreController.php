<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genre = Genre::latest()->get();

        $total = count($genre);

        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table genre berhasil ditampilkan',
            'total' => $total,
            'data'    => $genre
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
            'name'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $genre = Genre::create([
            'name'  => $request->name
        ]);

        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Data Genre is added successfully',
                'data'    => $genre
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Genre failed to save',
        ], 409);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre = Genre::find($id);

        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Get Detail Genre',
                'data'    => $genre
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
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $genre = Genre::find($id);

        if ($genre) {
            # meng-update data genre
            $genre->update([
                'name'  => $request->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Genre is update successfully',
                'data'    => $genre
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data dengan id : ' . $id . ' tidak ditemukan'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $genre = Genre::find($id);

        if ($genre) {
            $genre->delete();

            return response()->json([
                'success' => true,
                'message' => 'Genre is delete successfully',
                'data'    => $genre
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data dengan id : ' . $id . ' tidak ditemukan'
        ], 404);
    }

    public function search($name)
    {
        $genre = Genre::where('name', 'like', '%' . $name . '%')->get();

        $total = count($genre);

        if ($total) {
            $data = [
                'message' => 'Get searched resource',
                'total' => $total,
                'data' => $genre
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

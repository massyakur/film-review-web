<?php

namespace App\Http\Controllers;

use App\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
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
        $film = Film::latest()->get();

        $total = count($film);

        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table film berhasil ditampilkan',
            'total' => $total,
            'data'    => $film
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
            'title'   => 'required|max:45|unique:films,title',
            'description' => 'required',
            'tahun' => 'required|digits:4|numeric|max:' . (date('Y'))
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

        $film = Film::create([
            'title'  => $request->title,
            'description' => $request->description,
            'tahun' => $request->tahun
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Film is added successfully',
            'data'    => $film
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Film::find($id);

        if ($film) {
            return response()->json([
                'success' => true,
                'message' => 'Get Detail Film',
                'data'    => $film
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
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'max:45',
            'tahun' => 'digits:4|numeric|max:' . (date('Y'))
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $film = Film::find($id);

        $user = auth()->user();

        if ($user->role->name != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan admin!'
            ], 403);
        }

        $film->update([
            'title'  => $request->title ?? $film->title,
            'description' => $request->description ?? $film->description,
            'tahun' => $request->tahun ?? $film->tahun
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Film is update successfully',
            'data'    => $film
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Film  $film
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $film = Film::find($id);

        $user = auth()->user();

        if ($user->role->name != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan admin!'
            ], 403);
        }

        $film->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Film is delete successfully',
            'data'    => $film
        ], 200);
    }

    public function search($name)
    {
        $film = Film::where('title', 'like', '%' . $name . '%')->get();

        $total = count($film);

        if ($total) {
            $data = [
                'message' => 'Get searched resource',
                'total' => $total,
                'data' => $film
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

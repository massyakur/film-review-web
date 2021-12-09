<?php

namespace App\Http\Controllers;

use App\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $film = Film::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table film berhasil ditampilkan',
            'data'    => $film
        ], 200);
    }

    public function getDataById(Request $request)
    {
        $genre_id = $request->genre_id;

        $film = Film::where('genre_id', $genre_id)->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data user id : ' . $genre_id . ' berhasil ditampilkan',
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
            'title'   => 'required|max:45',
            'description' => 'required',
            'tahun' => 'required|digits:4|numeric|max:' . (date('Y')),
            'genre_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $film = Film::create([
            'title'  => $request->title,
            'description' => $request->description,
            'tahun' => $request->tahun,
            'genre_id' => $request->genre_id,
        ]);

        if ($film) {
            return response()->json([
                'success' => true,
                'message' => 'Data Film is added successfully',
                'data'    => $film
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Film failed to save',
        ], 409);
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
            # memberikan respon 200 dalam bentuk JSON
            # jika sesuai dengan id nya
            return response()->json([
                'success' => true,
                'message' => 'Get Detail Film',
                'data'    => $film
            ], 200);
        }

        # memberikan respon 404 dalam bentuk JSON
        # jika tidak sesuai dengan id nya
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

        # membuat kondisi jika ada salah satu
        # attribute data yang kosong, dan
        # memberikan respon dalam bentuk JSON
        # status code 400 artinya kesalahan saat validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $film = Film::find($id);

        if ($film) {
            # meng-update data profile
            $film->update([
                'title'  => $request->title ?? $film->title,
                'description' => $request->description ?? $film->description,
                'tahun' => $request->tahun ?? $film->tahun,
                'genre_id' => $request->genre_id ?? $film->genre_id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Film is update successfully',
                'data'    => $film
            ], 200);
        }

        # kesalahan dalam mengupdate data
        # maka akan muncul status code 404
        # jika tidak sesuai dengan id nya
        return response()->json([
            'success' => false,
            'message' => 'Data dengan id : ' . $id . ' tidak ditemukan'
        ], 404);
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

        if ($film) {
            $film->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Film is delete successfully',
                'data'    => $film
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data dengan id : ' . $id . ' tidak ditemukan'
        ], 404);
    }
}

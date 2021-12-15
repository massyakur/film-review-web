<?php

namespace App\Http\Controllers;

use App\GenreFilm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreFilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genre_film = GenreFilm::latest()->get();

        $total = count($genre_film);

        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table Genre Film berhasil ditampilkan',
            'total' => $total,
            'data'    => $genre_film
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
            'genre_id'   => 'required',
            'film_id' => 'required'
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

        foreach ($request->genre_id as $genre_id) {
            $genre_film = GenreFilm::create([
                'genre_id' => $genre_id,
                'film_id' => $request->film_id
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Genre Film is added successfully',
            'data'    => $genre_film
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $genre_film = GenreFilm::find($id);

        $user = auth()->user();

        if ($user->role->name != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan admin!'
            ], 403);
        }

        $genre_film->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Genre Film is delete successfully',
            'data'    => $genre_film
        ], 200);
    }

    public function getDataByGenreId(Request $request)
    {
        $genre_id = $request->genre_id;

        $genre_film = GenreFilm::where('genre_id', $genre_id)->latest()->get();

        $total = count($genre_film);

        return response()->json([
            'success' => true,
            'message' => 'Data genre id : ' . $genre_id . ' berhasil ditampilkan',
            'total' => $total,
            'data'    => $genre_film
        ], 200);
    }

    public function getDataByFilmId(Request $request)
    {
        $film_id = $request->film_id;

        $genre_film = GenreFilm::where('film_id', $film_id)->latest()->get();

        $total = count($genre_film);

        return response()->json([
            'success' => true,
            'message' => 'Data film id : ' . $film_id . ' berhasil ditampilkan',
            'total' => $total,
            'data'    => $genre_film
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $peran = Peran::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table peran berhasil ditampilkan',
            'data'    => $peran
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
            'film_id'   => 'required',
            'cast_id' => 'required',
            'name' => 'required|max:45'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $peran = Peran::create([
            'film_id'  => $request->film_id,
            'cast_id' => $request->cast_id,
            'name' => $request->name
        ]);

        if ($peran) {
            return response()->json([
                'success' => true,
                'message' => 'Data Peran is added successfully',
                'data'    => $peran
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Peran failed to save',
        ], 409);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $peran = Peran::find($id);

        if ($peran) {
            return response()->json([
                'success' => true,
                'message' => 'Get Detail Peran',
                'data'    => $peran
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'max:45'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $peran = Peran::find($id);

        if ($peran) {
            $peran->update([
                'film_id' => $request->film_id ?? $peran->film_id,
                'cast_id' => $request->cast_id ?? $peran->cast_id,
                'name'  => $request->name ?? $peran->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Peran is update successfully',
                'data'    => $peran
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $peran = Peran::find($id);

        if ($peran) {
            $peran->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data Peran is delete successfully',
                'data'    => $peran
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data dengan id : ' . $id . ' tidak ditemukan'
        ], 404);
    }

    public function getDataById(Request $request)
    {
        $film_id = $request->film_id;
        $cast_id = $request->cast_id;

        $peran = Peran::where('film_id', $film_id)->latest()->get();
        $peran = Peran::where('cast_id', $cast_id)->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data film id : ' . $film_id . ' dan data cast id : ' . $cast_id . ' berhasil ditampilkan',
            'data'    => $peran
        ], 200);
    }
}

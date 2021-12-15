<?php

namespace App\Http\Controllers;

use App\Peran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PeranController extends Controller
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
        $peran = Peran::latest()->get();

        $total = count($peran);

        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table peran berhasil ditampilkan',
            'total' => $total,
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

        $user = auth()->user();

        if ($user->role->name != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan admin!'
            ], 403);
        }

        $peran = Peran::create([
            'film_id'  => $request->film_id,
            'cast_id' => $request->cast_id,
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Peran is added successfully',
            'data'    => $peran
        ], 201);
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

        $user = auth()->user();

        if ($user->role->name != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan admin!'
            ], 403);
        }

        $peran->update([
            'name'  => $request->name ?? $peran->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Peran is update successfully',
            'data'    => $peran
        ], 200);
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

        $user = auth()->user();

        if ($user->role->name != 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda bukan admin!'
            ], 403);
        }

        $peran->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Peran is delete successfully',
            'data'    => $peran
        ], 200);
    }

    public function getDataById(Request $request)
    {
        $film_id = $request->film_id;
        $cast_id = $request->cast_id;

        $peran = Peran::where('film_id', $film_id)->latest()->get();
        $peran = Peran::where('cast_id', $cast_id)->latest()->get();

        $total = count($peran);

        return response()->json([
            'success' => true,
            'message' => 'Data film id : ' . $film_id . ' dan data cast id : ' . $cast_id . ' berhasil ditampilkan',
            'total' => $total,
            'data'    => $peran
        ], 200);
    }

    public function search($name)
    {
        $peran = Peran::where('name', 'like', '%' . $name . '%')->get();

        $total = count($peran);

        if ($total) {
            $data = [
                'message' => 'Get searched resource',
                'total' => $total,
                'data' => $peran
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

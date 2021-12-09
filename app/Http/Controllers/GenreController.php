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
        # mengambil data dari tabel genre
        $genre = Genre::latest()->get();

        # memberikan respon dalam bentuk JSON
        # dengan status code 200 yang artinya berhasil
        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table genre berhasil ditampilkan',
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
        # membuat validasi
        $validator = Validator::make($request->all(), [
            'name'   => 'required'
        ]);

        # membuat kondisi jika ada salah satu
        # attribute data yang kosong, dan
        # memberikan respon dalam bentuk JSON
        # status code 400 artinya kesalahan saat validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        # menyimpan data ke database
        $genre = Genre::create([
            'name'  => $request->name
        ]);

        # memberikan response message jika
        # data berhasil disimpan ke db, dan
        # memberikan response status code 201
        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Genre is added successfully',
                'data'    => $genre
            ], 201);
        }

        # gagal menyimpan data ke database
        return response()->json([
            'success' => false,
            'message' => 'Genre failed to save',
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
        # mencari data genre sesuai id nya
        $genre = Genre::find($id);

        if ($genre) {
            # memberikan respon 200 dalam bentuk JSON
            # jika sesuai dengan id nya
            return response()->json([
                'success' => true,
                'message' => 'Get Detail Genre',
                'data'    => $genre
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
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        # membuat validasi
        $validator = Validator::make($request->all(), [
            'name'   => 'required'
        ]);

        # membuat kondisi jika ada salah satu
        # attribute data yang kosong, dan
        # memberikan respon dalam bentuk JSON
        # status code 400 artinya kesalahan saat validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        # mencari data genre sesuai id nya
        $genre = Genre::find($id);

        if ($genre) {
            # meng-update data genre
            $genre->update([
                'name'  => $request->name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Genre is update successfully',
                'data'    => $genre
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

        # kesalahan dalam menghapus data
        # maka akan muncul status code 404
        # jika tidak sesuai dengan id nya
        return response()->json([
            'success' => false,
            'message' => 'Data dengan id : ' . $id . ' tidak ditemukan'
        ], 404);
    }
}

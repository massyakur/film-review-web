<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_id = $request->user_id;

        $profile = Profile::where('user_id', $user_id)->first();

        return response()->json([
            'success' => true,
            'message' => 'Data user id : ' . $user_id . ' berhasil ditampilkan',
            'data'    => $profile
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
            'user_id'   => 'required',
            'age' => 'required|numeric',
        ]);

        # membuat kondisi jika ada salah satu
        # attribute data yang kosong, dan
        # memberikan respon dalam bentuk JSON
        # status code 400 artinya kesalahan saat validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        # menyimpan data ke database
        $profile = Profile::create([
            'user_id'  => $request->user_id,
            'age' => $request->age,
            'bio' => $request->bio,
            'address' => $request->address,
        ]);

        # memberikan response message jika
        # data berhasil disimpan ke db, dan
        # memberikan response status code 201
        if ($profile) {
            return response()->json([
                'success' => true,
                'message' => 'Profile is added successfully',
                'data'    => $profile
            ], 201);
        }

        # gagal menyimpan data ke database
        return response()->json([
            'success' => false,
            'message' => 'Data Genre failed to save',
        ], 409);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        # membuat validasi
        $validator = Validator::make($request->all(), [
            'age' => 'numeric',
        ]);

        # membuat kondisi jika ada salah satu
        # attribute data yang kosong, dan
        # memberikan respon dalam bentuk JSON
        # status code 400 artinya kesalahan saat validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $profile = Profile::find($id);

        if ($profile) {
            # meng-update data profile
            $profile->update([
                'age'  => $request->age ?? $profile->age,
                'bio' => $request->bio,
                'address' => $request->address
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Profile is update successfully',
                'data'    => $profile
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
}

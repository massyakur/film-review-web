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
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required',
            'age' => 'required|numeric|digits:2',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $profile = Profile::create([
            'user_id'  => $request->user_id,
            'age' => $request->age,
            'bio' => $request->bio,
            'address' => $request->address,
        ]);

        if ($profile) {
            return response()->json([
                'success' => true,
                'message' => 'Data Profile is added successfully',
                'data'    => $profile
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Profile failed to save',
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
        $validator = Validator::make($request->all(), [
            'age' => 'numeric|digits:2',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $profile = Profile::find($id);

        if ($profile) {
            $profile->update([
                'age'  => $request->age ?? $profile->age,
                'bio' => $request->bio ?? $profile->bio,
                'address' => $request->address ?? $profile->address
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data Profile is update successfully',
                'data'    => $profile
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data dengan id : ' . $id . ' tidak ditemukan'
        ], 404);
    }
}

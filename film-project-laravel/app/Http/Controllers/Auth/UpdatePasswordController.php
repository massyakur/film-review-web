<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UpdatePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $allRequest = $request->all();

        # membuat validasi
        $validator = Validator::make($allRequest, [
            'email'   => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        # membuat kondisi jika ada salah satu
        # attribute data yang kosong, dan
        # memberikan respon dalam bentuk JSON
        # status code 400 artinya kesalahan saat validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'email tidak ditemukan'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password Berhasil diubah',
            'data' => $user
        ], 200);
    }
}

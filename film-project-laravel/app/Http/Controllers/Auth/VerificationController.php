<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\OtpCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
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
            'otp'   => 'required'
        ]);

        # membuat kondisi jika ada salah satu
        # attribute data yang kosong, dan
        # memberikan respon dalam bentuk JSON
        # status code 400 artinya kesalahan saat validasi
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $otp_code = OtpCode::where('otp', $request->otp)->first();

        if (!$otp_code) {
            return response()->json([
                'success' => false,
                'message' => 'OTP Code tidak ditemukan'
            ], 400);
        }

        $now = Carbon::now();
        if ($now > $otp_code->valid_until) {
            return response()->json([
                'success' => false,
                'message' => 'OTP Code tidak berlaku lagi'
            ], 400);
        }

        $user = User::find($otp_code->user_id);
        $user->update([
            'email_verified_at' => $now
        ]);

        $otp_code->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil diverifikasi',
            'data' => $user
        ], 200);
    }
}

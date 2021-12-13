<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::latest()->get();

        $total = count($user);

        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table user berhasil ditampilkan',
            'total' => $total,
            'data'    => $user
        ], 200);
    }

    public function search($name)
    {
        $user = User::where('name', 'like', '%' . $name . '%')->get();

        $total = count($user);

        if ($total) {
            $data = [
                'message' => 'Get searched resource',
                'total' => $total,
                'data' => $user
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

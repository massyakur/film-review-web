<?php

namespace App\Http\Controllers;

use App\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
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
        $feedback = Feedback::latest()->get();

        $total = count($feedback);

        return response()->json([
            'success' => true,
            'message' => 'Semua daftar table feedback berhasil ditampilkan',
            'total' => $total,
            'data'    => $feedback
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
            'film_id' => 'required',
            'ulasan' => 'required',
            'rating' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $feedback = Feedback::create([
            'user_id' => $request->user_id,
            'film_id'  => $request->film_id,
            'ulasan' => $request->ulasan,
            'rating' => $request->rating
        ]);

        if ($feedback) {
            return response()->json([
                'success' => true,
                'message' => 'Data Feedback is added successfully',
                'data'    => $feedback
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Data Feedback failed to save',
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
        $feedback = Feedback::find($id);

        if ($feedback) {
            return response()->json([
                'success' => true,
                'message' => 'Get Detail Feedback',
                'data'    => $feedback
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
            'rating' => 'regex:/^[0-9]+(\.[0-9][0-9]?)?$/'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $feedback = Feedback::find($id);

        $user = auth()->user();

        if ($feedback->user_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Data bukan milik anda!'
            ], 403);
        }

        $feedback->update([
            'ulasan'  => $request->ulasan ?? $feedback->ulasan,
            'rating' => $request->rating ?? $feedback->rating
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Feedback is update successfully',
            'data'    => $feedback
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
        $feedback = Feedback::find($id);

        $user = auth()->user();

        if ($feedback->user_id != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Data bukan milik anda!'
            ], 403);
        }

        $feedback->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Feedback is delete successfully',
            'data'    => $feedback
        ], 200);
    }

    public function getDataById(Request $request)
    {
        $user_id = $request->user_id;
        $film_id = $request->film_id;

        $feedback = Feedback::where('user_id', $user_id)->latest()->get();
        $feedback = Feedback::where('film_id', $film_id)->latest()->get();

        $total = count($feedback);

        return response()->json([
            'success' => true,
            'message' => 'Data user id : ' . $user_id . ' dan data film id : ' . $film_id . ' berhasil ditampilkan',
            'total' => $total,
            'data'    => $feedback
        ], 200);
    }
}

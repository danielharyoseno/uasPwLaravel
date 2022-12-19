<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Validator;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pengumumans = Pengumuman::all();

        if (count($pengumans) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pengumans,
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null,
        ], 400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'headline' => 'required',
            'isi' => 'required',
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }

        $pengumuman = Pengumuman::create($storeData);
        return response([
            'message' => 'Add pengumuman Success',
            'data' => $pengumuman,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pengumuman = Pengumuman::find($id);

        if (!is_null($pengumuman)) {
            return response([
                'message' => 'Retrieve pengumuman Success',
                'data' => $pengumuman,
            ], 200);
        }

        return response([
            'message' => 'pengumuman Not Found',
            'data' => null,
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
        $pengumuman = Pengumuman::find($id);
        if (is_null($pengumuman)) {
            return response([
                'message' => 'pengumuman Not Found',
                'data' => null,
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'headline' => 'required',
            'isi' => 'required',
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }

        $pengumuman->headline = $updateData['headline'];
        $pengumuman->isi = $updateData['isi'];

        if ($pengumuman->save()) {
            return response([
                'message' => 'Update pengumuman Success',
                'data' => $pengumuman,
            ], 200);
        }

        return response([
            'message' => 'Update pengumuman Failed',
            'data' => null,
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pengumuman = Pengumuman::find($id);

        if (is_null($pengumuman)) {
            return response([
                'message' => 'pengumuman Not Found',
                'data' => null,
            ], 404);
        }

        if ($pengumuman->delete()) {
            return response([
                'message' => 'Delete pengumuman Success',
                'data' => $pengumuman,
            ], 200);
        }

        return response([
            'message' => 'Delete pengumuman Failed',
            'data' => null,
        ], 400);
    }
}
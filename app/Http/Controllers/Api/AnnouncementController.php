<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Validator;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $announcements = Announcement::all();

        if (count($announcements) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $announcements,
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null,
        ], 400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $announcements = Announcement::create($storeData);
        return response([
            'message' => 'Add pengumuman Success',
            'data' => $announcements,
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
        $announcement = Announcement::find($id);

        if (!is_null($announcement)) {
            return response([
                'message' => 'Retrieve pengumuman Success',
                'data' => $announcement,
            ], 200);
        }

        return response([
            'message' => 'pengumuman Not Found',
            'data' => null,
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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
        $announcement = Announcement::find($id);
        if (is_null($announcement)) {
            return response([
                'message' => 'announcement Not Found',
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

        $announcement->headline = $updateData['headline'];
        $announcement->isi = $updateData['isi'];

        if ($announcement->save()) {
            return response([
                'message' => 'Update pengumuman Success',
                'data' => $announcement,
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
        $announcement = Announcement::find($id);

        if (is_null($announcement)) {
            return response([
                'message' => 'announcement Not Found',
                'data' => null,
            ], 404);
        }

        if ($announcement->delete()) {
            return response([
                'message' => 'Delete announcement Success',
                'data' => $announcement,
            ], 200);
        }

        return response([
            'message' => 'Delete announcement Failed',
            'data' => null,
        ], 400);
    }
}
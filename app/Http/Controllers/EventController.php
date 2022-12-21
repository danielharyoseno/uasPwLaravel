<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;

class OrganizerController extends Controller
{
    public function index(){
        $organizer = Organizer::all();

        if (count($organizer) > 0) {
            return response()->json([
                'message'   => 'Retrieve All Success',
                'data'      => $organizer
            ], 200);
        };

        return response()->json([
            'message'       => 'Empty',
            'data'          => null
        ], 200);
    }

    public function show($id)
    {
        $organizer = Organizer::find($id);

        if (!is_null($organizer)) {
            return response()->json([
                'message'   => 'Retrieve Organizer Success',
                'data'      => $organizer
            ], 200);
        }

        return response()->json([
            'message'   => 'Organizer Not Found',
            'data'      => null
        ], 404);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama_event'         => 'required',
            'jumlah_peserta'       => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message'   => 'Validation Error',
                'data'      => $validator->errors()
            ], 400);
        }

        $organizer = Organizer::create([
            'nama_event'         => $request->nama_event,
            'jumlah_peserta'    => $request->jumlah_peserta,
        ]);

        if ($organizer) {
            return response()->json([
                'message'   => 'Organizer created',
                'data'      => $organizer,
            ], 201);
        }

        return response()->json([
            'message'      => 'Organizer failed to save',
            'data'         => null,
        ], 400);
    }

    public function update(Request $request, $id)
    {

        $organizer = Organizer::find($id);

        if (is_null($organizer)) {
            return response()->json([
                'message'   => 'Event not found',
                'data'      => null,
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'nama_event' => 'required|max:255',
            'jumlah_peserta' => 'required',
        ]);

        if ($validate->fails()) {
            return response(['message' => $validate->errors()], 400);
        }

        $organizer->update($updateData);

        return response()->json([
            'message'   => 'Update Organizer Success',
            'data'      => $organizer
        ], 200);
    }

    public function destroy($id)
    {
        $organizer = Organizer::find($id);

        if (is_null($organizer)) {
            return response()->json([
                'message'   => 'Organizer Not Found',
                'data'      => null
            ], 404);
        }

        $organizer->delete();

        return response()->json([
            'message'   => 'Delete Organizer Success',
            'data'      => $organizer
        ], 200);
    }
}
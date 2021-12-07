<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRooms;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Room[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Room::all();
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRooms $request)
    {
        $inputs = $request->only(['type_id', 'view_id', 'bed_number', 'price','size']);
        if (!hasRole('Manager')) {
            if (!hasRole('Supervisor')) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are not allowed to add'
                ]);
            }
        }
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('upload/product/rooms/', $filename);
            $event = new Room();
            $event->fill($inputs);
            $event->picture = 'upload/product/rooms/' . $filename;
        }
        $event->save();
        return response()->json([
            'status' => 200,
            'message' => 'Room added successfully'
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreRooms $request, $id)
    {
        $room=Room::where('id',$id)->first();
        $inputs = $request->all();
        if(!hasRole('Manager')) {
            if (!hasRole('Supervisor')) {
                return response()->json([
                    'message' => 'You are not allowed to update'
                ]);
            }else{
                $room->update($inputs);
                return response()->json([
                    'message'=>'The Room has been updated',
                    'status' => 200
                ]);
            }
        }else{
            $room->update($inputs);
            return response()->json([
                'message'=>'the Employee has been updated',
                'status' => 200
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Room $room
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (!hasRole('Manager')) {
            if (!hasRole('Supervisor')) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are not allowed to delete'
                ]);
            }
        }
        $room = Room::where('id', $id)->delete();
        if ($room) {
            return response()->json([
                'status' => 200,
                'message' => '$room has been deleted'
            ]);
        }
        return response()->json([
            'message'=>'Room Not Deleted'
        ]);
    }
    public function additional(): \Illuminate\Http\JsonResponse
    {
       $additional = Room::with('types','views','amenities','features')->get();
       if($additional)
           return response()->json([
               'status'=>200,
               'message'=>$additional
           ]);
        return response()->json([
            'status'=>403,
            'message'=>'Oops something went wrong'
        ]);
    }
    public function filterbyview($id){
        if($id > 0){
            $additional = Room::with('types','views','amenities','features')->where('view_id',$id)->get();
            if($additional)
                return response()->json([
                    'status'=>200,
                    'message'=>$additional
                ]);
            return response()->json([
                'status'=>403,
                'message'=>'Oops something went wrong'
            ]);
        }else{
            $additional = Room::with('types','views','amenities','features')->get();
            if($additional)
                return response()->json([
                    'status'=>200,
                    'message'=>$additional
                ]);
            return response()->json([
                'status'=>403,
                'message'=>'Oops something went wrong'
            ]);
        }


    }
    public function filterbytype($id){
        if($id > 0){
            $additional = Room::with('types','views','amenities','features')->where('type_id',$id)->get();
            if($additional)
                return response()->json([
                    'status'=>200,
                    'message'=>$additional
                ]);
            return response()->json([
                'status'=>403,
                'message'=>'Oops something went wrong'
            ]);
        }else{
            $additional = Room::with('types','views','amenities','features')->get();
            if($additional)
                return response()->json([
                    'status'=>200,
                    'message'=>$additional
                ]);
            return response()->json([
                'status'=>403,
                'message'=>'Oops something went wrong'
            ]);
        }


    }
}

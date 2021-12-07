<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvents;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Event[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Event::all();
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreEvents $request)
    {
        $inputs = $request->only(['day','month','description','title']);
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('upload/product/', $filename);
            $event = new Event();
            $event->fill($inputs);
            $event->picture = 'upload/product/' . $filename;
        }
        $event->save();
        return response()->json([
            'status'=>200,
            'message'=>'Event added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreEvents $request, $id)
    {
        $events=Event::where('id',$id)->first();
        $inputs = $request->only(['day','month','title','description']);
        if(!hasRole('Manager') ) {
            if(!hasRole('Supervisor')) {
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
            $file->move('upload/product/', $filename);
            $events->picture = 'upload/product/' . $filename;
            $events->update($inputs);
        }

        return response()->json([
            'status'=>200,
            'response'=>$events,
            'message'=>'Events Updated Successfully'
        ]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if(!hasRole('Manager') ) {
            if(!hasRole('Supervisor')) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are not allowed to add'
                ]);
            }
        }
        $events=Event::where('id',$id)->delete();
        if($events){
            return response()->json([
                'message'=>'Event Deleted Successfully',
                'status'=>200
            ]);
        }
    }
}

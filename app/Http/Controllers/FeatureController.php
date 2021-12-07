<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeatures;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Feature::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Feature[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreFeatures $request)
    {
        $inputs = $request->all();
        if (!hasRole('Manager')) {
            if (!hasRole('Supervisor')) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are not allowed to add'
                ]);
            }
        }
        $type = new Feature();
        $type->fill($inputs);
        $type->save();
        return response()->json([
            'message'=>'The Feature of the Room has been added Successfully',
            'status'=>200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function show(Feature $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function edit(Feature $feature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feature $feature)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feature  $feature
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if(!hasRole('Manager') ) {
            if(!hasRole('Supervisor')) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You are not allowed to delete'
                ]);
            }
        }
        $news=Feature::where('id',$id)->delete();
        if($news){
            return response()->json([
                'status'=>200,
                'message'=>'Feature has been deleted'
            ]);
        }
    }
}

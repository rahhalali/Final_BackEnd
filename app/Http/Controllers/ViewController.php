<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreView;
use App\Models\Room;
use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return View::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
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
    public function store(StoreView $request)
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
        $view = new View();
        $view->fill($inputs);
        $view->save();
        return response()->json([
            'message'=>'The View of the Room has been added Successfully',
            'status'=>200
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\View  $view
     * @return \Illuminate\Http\Response
     */
    public function show(View $view)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\View  $view
     * @return \Illuminate\Http\Response
     */
    public function edit(View $view)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\View  $view
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, View $view)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\View  $view
     * @return \Illuminate\Http\Response
     */
    public function destroy(View $view)
    {
        //
    }

}

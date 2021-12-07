<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNews;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return News[]|\Illuminate\Database\Eloquent\Collection|Response
     */
    public function index()
    {
        return News::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(StoreNews $request )
    {
        $inputs = $request->only(['title','description']);
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
            $news = new News();
            $news->fill($inputs);
            $news->picture = 'upload/product/' . $filename;
        }

        $news->save();
        return response()->json([
            'status'=>200,
            'message'=>'News added Successfully'
        ]);
}

    /**
     * Display the specified resource.
     *
     * @param News $news
     * @return Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param News $news
     * @return Response
     */
    public function edit(News $news)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param News $news
     * @return JsonResponse
     */
    public function update(StoreNews $request, $id)
    {
        $news=News::where('id',$id)->first();
        $inputs = $request->all();
        if(!hasRole('Manager')) {
            if (!hasRole('Supervisor')) {
                return response()->json([
                    'message' => 'You are not allowed to update'
                ]);
            }else{
                $news->update($inputs);
                return response()->json([
                    'message'=>'The News has been updated',
                    'status' => 200
                ]);
            }
        }else{
            $news->update($inputs);
            return response()->json([
                'message'=>'the Employee has been updated',
                'status' => 200
            ]);
            }

        }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
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
        $news=News::where('id',$id)->delete();
        if($news){
            return response()->json([
                'status'=>200,
                'message'=>'News has been deleted'
            ]);
        }
    }
}

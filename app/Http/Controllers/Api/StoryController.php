<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stories = Story::paginate(10);
        return response()->json($stories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['title'=>"required","content"=>"required", 'author' => 'required',"image"=>"required|image|max:4096"]
        );
        if(!$validator->fails()){
            Story::saveData($request);
        }
        else{
            return response()->json($validator->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Story::find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['title'=>"required","content"=>"required", 'author' => 'required',"image"=>"sometimes|image|max:4096"]
        );
        $str = Story::find($id);
        if(!$validator->fails()){
            Story::updateData($request, $str);
        }
        else{
            return response()->json($validator->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $str = Story::find($id);
        Storage::delete($str->image);
        $str->delete();
    }

    public function search(Request $request){

        if ($search = $request->get('q')) {
            $stories = Story::where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $stories = Story::latest()->paginate(10);
        }

        return $stories;
    }

    public function searchByTime (Request $request){
        $search = $request->get('q');
        if ($search) {
            $stories = Story::where(function($query) use ($search){
                $query->where('created_at','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $stories = Story::latest()->paginate(10);
        }
        return $stories;
    }
}

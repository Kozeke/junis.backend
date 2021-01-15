<?php

namespace App\Http\Controllers\Api;

use App\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::all();
        return response()->json($galleries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),["title"=>"required|max:255","image"=>"required|image|max:4096"]);
        if(!$validator->fails()){
            Gallery::saveData($request);
        }
        else{
            return response()->json(["status"=>false,"errors"=>$validator->fails()]);
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
        $gallery = Gallery::find($id);
        return response()->json($gallery);
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
        $gallery = Gallery::find($id);
        if($gallery){
            $validator = Validator::make($request->all(),["title"=>"required|max:255","image"=>"nullable|sometimes|image|max:4096"]);
            if(!$validator->fails()){
                Gallery::updateData($request,$gallery);
            }
            else{
                return response()->json(["status"=>false,"errors"=>$validator->errors()]);
            }

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
        if($gallery = Gallery::find($id)){
            Storage::delete($gallery->image);
            $gallery->delete();
        }
    }
}

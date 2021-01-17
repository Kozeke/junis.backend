<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publications = Publication::with('publicationImages')->paginate(10);
        return response()->json($publications);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        ['title'=>"required","description"=>"required","file"=>"required|file|max:4096","image"=>"required|image|max:4096"]
        );
        if(!$validator->fails()){
            Publication::saveData($request);
        }
        else{
            return response()->json($validator->errors(),422);
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
        $publication = Publication::with("publicationImages")->find($id);
        return  response()->json($publication);

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
        $publication = Publication::find($id);
        if($publication){
            $validator = Validator::make($request->all(),
                ['title'=>"required","description"=>"required","file"=>"sometimes|file|max:4096", 'image' => 'sometimes|image|max:4096'
                    ]
            );
            if(!$validator->fails()){
                Publication::updateData($request,$publication);
            }
            else{
                return response()->json($validator->errors(), 422);
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
        $pub = Publication::find($id);
        Storage::delete($pub->file);
        foreach ($pub->publicationImages as $publicationImage) {
            Storage::delete($publicationImage->url);
        }
        $pub->delete();
    }

    public function search (Request $request){
        $search = $request->get('q');
        if ($search) {
            $publications = Publication::with('publicationImages')->where(function($query) use ($search){
                $query->where('title','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $publications = Publication::with('publicationImages')->latest()->paginate(10);
        }
        return $publications;
    }

    public function searchByTime (Request $request){
        $search = $request->get('q');
        if ($search) {
            $publications = Publication::with('publicationImages')->where(function($query) use ($search){
                $query->where('created_at','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $publications = Publication::with('publicationImages')->latest()->paginate(10);
        }
        return $publications;
    }
}

<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Models\Story;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function gallery(){
        return response()->json(Gallery::all());
    }

    public function stories(){
        return response()->json(Story::latest("updated_at")->take(3)->get()->toArray());
    }
}

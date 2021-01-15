<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\Models\Story;
use App\Publication;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    public function gallery(){
        return response()->json(Gallery::all());
    }

    public function stories(){
        return response()->json(Story::latest("updated_at")->take(3)->get()->toArray());
    }

    public function allPublications(){
            $main = Publication::with("publicationImages")->latest("updated_at")->where("main",1)->first();
            if ($main){$second_main = Publication::with("publicationImages")->latest("updated_at")->where("main",1)->where("id","!=",$main->id)->take(3)->get();} else{$second_main = Publication::with("publicationImages")->latest("updated_at")->where("main",1)->take(3)->get();}
            $top = Publication::with("publicationImages")->orderBy("download","DESC")->take(9)->get()->toArray();
            $all = Publication::with("publicationImages")->orderBy("updated_at","DESC")->paginate(3)->toArray();
            return response()->json(["main"=>$main,"second_main"=>$second_main,"top"=>$top,"all"=>$all]);
    }

    public function showPublication($id){
        return response()->json(Publication::with("publicationImages")->find($id));
    }

    public function downloadPublication($id){
        if($publication = Publication::find($id)){
            $publication->download +=1;
            $publication->save();
            return Storage::download($publication->file);
        }
    }
}

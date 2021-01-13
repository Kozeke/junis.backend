<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;

    public static function saveFile($request,$name,$directory,$title=null){
        if($request->hasFile($name)){
            $file = $request->file($name);
            $filename = $title ? Str::slug($title) . Str::random(5) . "." . $file->getClientOriginalExtension() : Str::random(12) . "." . $file->getClientOriginalExtension();
            $file->storeAs($directory,$filename);
            return $directory . $filename;
        }
        else{
            return null;
        }
    }

    public static function saveImage($file, $directory){
            $filename = Str::random(12) . "." . $file->getClientOriginalExtension();
            $file->storeAs($directory,$filename);
            return $directory . $filename;
    }




}

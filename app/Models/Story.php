<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Story extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'author', 'image', 'created_at', 'updated_at'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];

    public static function saveData($request){
        $model = new self();
        $input = $request->all();
        $input["image"] = File::saveFile($request,"image","/uploads/stories/",$request->title);
        $model->fill($input);
        $model->save();
    }

    public static function updateData($request, $model){
        $input = $request->all();
        if ($request->hasFile('image')) {
            Storage::delete($model->image);
            $input["image"] = File::saveFile($request,"image","/uploads/stories/",$request->title);
        }
        $model->update($input);
        $model->save();
    }
}

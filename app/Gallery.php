<?php

namespace App;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $created_at
 * @property string $updated_at
 */
class Gallery extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['title', 'image', 'created_at', 'updated_at'];



    public static function saveData($request){
        $model = new self();
        $input = $request->all();
        $input["image"] = File::saveFile($request,"image","/uploads/galleries/",$request->title);
        $model->fill($input);
        return $model->save();
    }

    public static function updateData($request,$model){
        $input = $request->all();
        if($request->hasFile("image")){
            Storage::delete($model->image);
            $input["image"] = File::saveFile($request,"image","/uploads/galleries/",$request->title);
        }
        $model->update($input);
        $model->save();
    }

}

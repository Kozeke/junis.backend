<?php

namespace App;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $file
 * @property int $main
 * @property int $download
 * @property string $created_at
 * @property string $updated_at
 * @property PublicationImage[] $publicationImages
 */
class Publication extends Model
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
    protected $fillable = ['title', 'description', 'file', 'main', 'download', 'created_at', 'updated_at'];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicationImages()
    {
        return $this->hasMany('App\PublicationImage');
    }


    public static function saveData($request){
        $model = new self();
        $input = $request->all();
        $input['main'] = $request['is_main'] == 'true' ? 1 : 0;
        $input["file"] = File::saveFile($request,"file","/uploads/publications/",$request->title);
        $model->fill($input);
        if($model->save()){
            PublicationImage::saveImage($model->id,$request->file('image'));
        }
        else{

        }
    }


    public static function updateData($request, $model){
        $input = $request->all();
        if($request->hasFile("file")){
            Storage::delete($model->file);
            $input["file"] = File::saveFile($request,"file","/uploads/publications/",$request->title);
        }
        if ($request->hasFile('image')) {
            foreach ($model->publicationImages as $publicationImage) {
                Storage::delete($publicationImage->url);
                $publicationImage->delete();
            }
            PublicationImage::saveImage($model->id,$request->file('image'));
        }
        $input["main"] = $request->boolean("main");
        $model->update($input);
        $model->save();
    }
}

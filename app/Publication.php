<?php

namespace App;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;

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
        $input["file"] = File::saveFile($request,"file","/uploads/publications/",$request->title);
        $model->fill($input);
        if($model->save()){
            PublicationImage::saveImage($model->id,$request->images);
        }
        else{

        }
    }
}

<?php

namespace App;

use App\Models\File;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $publication_id
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 * @property Publication $publication
 */
class PublicationImage extends Model
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
    protected $fillable = ['publication_id', 'url', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function publication()
    {
        return $this->belongsTo('App\Publication');
    }


    public static function saveImage($id,$files){
        foreach ($files as $file){
            $model = new self;
            $model->publication_id = $id;
            $model->url = File::saveImage($file,"/uploads/publications/");
            $model->save();
        }

    }
}

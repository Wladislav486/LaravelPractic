<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    protected $fillable = [
        'title', 'description', 'category_id', 'content', 'thumbnail'
    ];

    use Sluggable;

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function uploadImage(Request $request, $image = null)
    {
        if($request->hasFile('thumbnail')){
            if($image){
                Storage::delete($image);
            }
            /**
             * загрузка картинки на сервер
             * размещение картинок по папкам с датой
             */
            $folder = date('Y-m-d');
            return $request->file('thumbnail')->store('images/' . $folder);
        }
        return null;
    }


    public function getImage()
    {
        if(!$this->thumbnail){
            return asset('no-image.png');
        }
        return asset('uploads/' . $this->thumbnail);
    }

    public function getPostDate()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)
            ->format('d F, Y');
    }

}

<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Post;

class Post extends Model
{

    use Sluggable;

    

	// protected $sluggable = [
	// 	'build_from' => 'title',
    //     'save_to'    => 'slug',
    //     'max_length'      => 50,
    //     'on_update'       => true,
    // ];
    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate'=> true,
                'maxLength'=> 50,
            ]
        ];
    }

    private $defualt_img    =   'images/default-post.jpg';
    protected $fillable =   ['title','body','category_id','user_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function photos(){
        return $this->morphMany('App\Photo','photoable');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function showPhoto(Post $post){
        //  return $user;

        $photos =   $post->photos;
        if(count($photos)>0){
            return asset($photos[0]->path);
        }else{
            return asset($this->defualt_img);
        }
    }
}

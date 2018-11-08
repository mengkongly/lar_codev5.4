<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class Post extends Model
{
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

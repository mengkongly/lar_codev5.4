<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Photo;

class User extends Authenticatable
{
    use Notifiable;

    private $defualt_img    =   'images/default-user.jpg';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id','is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('App\Role');
    }

    // public function getIsActiveAttribute($value){
    //     return ($value?'Actived':'Not Active');
    // }

    // public function setIsActiveAttribute($value){
    //     return ($value=='on'?1:0);
    // }

    public function photos(){
        return $this->morphMany('App\Photo','photoable');
    }

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function commentReplies(){
        return $this->hasMany('App\CommentReply');
    }

    public function showPhoto(User $user){
        //  return $user;

        $photos =   $user->photos;
        if(count($photos)>0){
            return asset($photos[0]->path);
        }else{
            return asset($this->defualt_img);
        }
    }


    public function isAdmin(){
        if($this->role->name    ==  "Administrator" && $this->is_active == 1){
            return true;
        }
        return false;
    }

    public function showActivedStatus($is_active){
        if($is_active==1){
            return 'Actived';
        }else{
            return 'Not Active';
        }
    }

}

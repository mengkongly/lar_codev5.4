<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\PostRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    // private $user;

    public function __construct()
    {
        // $this->user =   Auth::user();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user   =   Auth::user();
        $posts      =   $user->posts;
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories =   Category::all();
        return view('admin.posts.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        $user   =   Auth::user();   // get user from login auth        

        $photo  =   [];
        if($request->hasFile('file')){ //..check if file existed

            $file = $request->file('file');
            $file_name  =   'post_'.time().'_'.$file->getClientOriginalName();
            // it will create images folder in public directory to store images
            $file->move('images',$file_name);

            $photo['path']  =   $file_name;            
        }

        $input  =   $request->all();
        $post  =   $user->posts()->create($input);  // insert post by user and return $post object

        $post->photos()->create($photo);    // insert photo path to photo table by $post object
        
        Session::flash('success_post','Your post has been inserted successfully.');

        // return $request->all();
        return redirect(route('posts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user   =   Auth::user();
        $post   =   $user->posts->find($id);
        $categories =   Category::all();

        // return $post;
        return view('admin.posts.edit',compact('post','categories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $user   =   Auth::user();
        $post   =   $user->posts->find($id);

        $photo['path']  =   (count($post->photos)>0)?$post->photos[0]->path:'';
        // return public_path(). '/'.$photo['path'];
        if($request->hasFile('file')){ //..check if file existed
            
            $file = $request->file('file');
            $file_name  =   'post_'. time().'_'.$file->getClientOriginalName();
            // it will create images folder in public directory to store images
            $file->move('images',$file_name);

            // delete old image file
            if(!empty($photo['path'])){
                // Storage::delete($photo['path']);
                unlink(public_path(). '/'. $post->photos[0]->path);
            }
            // File::delete(public_path() . '/images/profile/', $article->file->name);

            //change image name
            $photo['path']  =   $file_name;

            // update/save photo to Photos table by $user
            if(count($post->photos)>0){
                $post->photos()->update($photo);
            }else{
                $post->photos()->create($photo);
            }
        }
        $input  =   $request->all();
        // return $request->all();
        // return $input;
        //return $request->is_active;
        $post->update($input);

        Session::flash('success_post','The post has been updated successfully.');
        return redirect(route('posts.index'));

        // return $post;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return 'destroy';
        $user   =   Auth::user();
        $post   =   $user->posts->find($id);

        if(count($post->photos)>0){
            unlink(public_path(). '/'. $post->photos[0]->path);
            $post->photos()->delete();
        }
        
        $post->delete();
        Session::flash('success_post','The post has been deleted successfully.');
        return 'success';
    }
}

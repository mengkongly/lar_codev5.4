<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use Illuminate\Support\Facades\Session;

class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments   =   Comment::all();
        return view('admin.comments.index',compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
            $user   =   Auth::user();
            $comment    =   $request->all();
            $comment['user_id']  =   $user->id;
            $comment['is_active']   =   1;

            $is_success =   Comment::create($comment);
            if($is_success){
                Session::flash('success_comment','The comment has been added successfully.');
            }else{
                Session::flash('error_comment','Failed to comment.');
            }
        }else{
            Session::flash('error_comment','Please login to make comment.');
        }
        //return $user;
        // return redirect(route('post.detail',['id'=>$request->get('post_id')]));
        return redirect()->back();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $is_updated  =   Comment::findOrFail($id)->update($request->all());
        // return var_dump($request->all());
        if($is_updated){

            if($request->is_active==1)
                Session::flash('success_comment','The comment has been approved successfully.');
            else
                Session::flash('success_comment','The comment has been un-approved successfully.');

            return 'success';
        }

        return 'error';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $is_deleted  =   Comment::findOrFail($id)->delete();
        // return var_dump($request->all());
        if($is_deleted){
            Session::flash('success_comment','The comment has been deleted successfully.');
            return 'success';
        }

        return 'error';
    }
}

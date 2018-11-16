<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\CommentReply;
use Illuminate\Support\Facades\Session;

class CommentRepliesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function replyComment(Request $request,$id){
        if(Auth::check()){
            $user   =   Auth::user();
            $reply    =   $request->all();
            $reply['comment_id']    =   $id;
            $reply['user_id']  =   $user->id;
            $reply['is_active']   =   1;

            $is_success =   CommentReply::create($reply);
            if($is_success){
                Session::flash('success_comment','The Reply has been added successfully.');            
            }else{
                Session::flash('error_comment','Failed to Reply.');
            }
        }else{
            Session::flash('error_comment','Please login to make Reply.');
        }
        return 'done';
        //return $user;
        // return redirect(route('post.detail',['id'=>$request->get('post_id')]));
        // return redirect()->back();

    }
}

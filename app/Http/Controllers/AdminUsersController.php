<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserEditRequest;
use Illuminate\Support\Facades\Storage;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return "Admin Users controller is working";        
        // $users   =   User::with(['roles'=>function($q){
        //     $q->select('name');
        // }])->get();
        $users   =   User::with('role')->get();

        //return $users; 
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles  =   Role::all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $photo  =   [];
        if($request->hasFile('file')){ //..check if file existed

            $file = $request->file('file');
            $file_name  =   time().'_'.$file->getClientOriginalName();
            // it will create images folder in public directory to store images
            $file->move('images',$file_name);

            $photo['path']  =   $file_name;            
        }
        
        $input  =   $request->all();
        $input['is_active'] =   $this->checkBoxIsActive($input);

        //return $request->all();
        $request['password']    =   bcrypt($request['password']);
        $user =   User::create($request->all());

        // save photo to Photos table by $user
        $user->photos()->create($photo);
        return redirect('/users');
        
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
        $user   =   User::with('photos')->whereId($id)->first();
        $roles  =   Role::all();   
        return view('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, $id)
    {
        $user   =   User::with('photos')->find($id);
        
        //$photo['path']  =   (count($user->photos)>0)?$user->photos[0]->path:'';
        if($request->hasFile('file')){ //..check if file existed
            
            $file = $request->file('file');
            $file_name  =   time().'_'.$file->getClientOriginalName();
            // it will create images folder in public directory to store images
            $file->move('images',$file_name);

            // delete old image file
            if(!empty($photo['path'])){
                Storage::delete($photo['path']);
            }
            // File::delete(public_path() . '/images/profile/', $article->file->name);

            //change image name
            $photo['path']  =   $file_name;

            // update/save photo to Photos table by $user
            if(count($user->photos)>0){
                $user->photos()->update($photo);
            }else{
                $user->photos()->create($photo);
            }
        }
        $input  =   $request->all();
        $input['is_active'] =   $this->checkBoxIsActive($input);
        // if(isset($input['is_active'])){
        //     $input['is_active']     =   1;
        // }else{
        //     $input['is_active']     =   0;
        // }
        // return $request->all();
        // return $input;
        //return $request->is_active;
        $user->update($input);

        return redirect('/users');
        
        // return $request->all();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user   =   User::findOrFail($id);
        $user->photos()->delete();
        $user->delete();
        return 'success';
    }

    private function checkBoxIsActive($input){
        if(isset($input['is_active'])){
            return 1;
        }else{
            return 0;
        }
    }
}

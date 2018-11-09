<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\Session;

class AdminCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories =   Category::all();
        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Category::create($request->all())){
            Session::flash('success_cate','The category has been inserted successfully.');
        }else{
            Session::flash('error_cate','The category failed to insert.');
        }

        return redirect(route('categories.index'));
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
        $category   =   Category::findOrFail($id);
        return view('admin.categories.edit',compact('category'));
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
        $is_updated =   Category::find($id)->update($request->all());
        if($is_updated){
            Session::flash('success_cate','The category has been updated successfully.');
        }else{
            Session::flash('error_cate','The category failed to update.');
        }
        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $is_delete  =   Category::find($id)->delete();
        if($is_delete){
            Session::flash('success_cate','The category has been deleted successfully.');
        }else{
            Session::flash('error_cate','The category failed to delete.');
        }
        return 'done';
    }
}

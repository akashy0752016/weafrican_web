<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\BussinessCategory;
use App\Helper;
use Image;
use Validator;

class AdminBussinessCategoriesController extends Controller
{

    public function __construct()
    {
        $deleteImage = new BusinessProductsController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Business Categories';
        $categories = BussinessCategory::get();
        return view('admin.categories.index', compact('pageTitle', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Admin - Create Business Category";
        $categories = BussinessCategory::where('parent_id',0)->get();
        return view('admin.categories.create', compact('pageTitle','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), BussinessCategory::$validater );

        if ($validator->fails()) {
            return redirect('admin/bussiness/category/create')->withErrors($validator)->withInput();
        }

        if($request->file('category_image')->isValid()) {
            $file = $key = md5(uniqid(rand(), true));
            $ext = $request->file('category_image')->getClientOriginalExtension();
            $image = $file.'.'.$ext;
            $img = Image::make($request->file('category_image')->getRealPath());

            $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
            })->save(config('image.category_image_path').'/thumbnails/large/'.$image);

            $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
            })->save(config('image.category_image_path').'/thumbnails/medium/'.$image);
            
            $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                 $constraint->aspectRatio();
            })->save(config('image.category_image_path').'/thumbnails/small/'.$image);
            $fileName = $request->file('category_image')->move(config('image.category_image_path'), $image);

        } else {
            return redirect('admin/bussiness/category/create')->with('Error', 'Category image is not uploaded. Please try again');
        }

        $input = $request->input();
        $input['image'] = $image;
        $category = array_intersect_key($input, BussinessCategory::$updatable);
        try{

            $category = new BussinessCategory($category);

            $category->slug = Helper::slug($input['title'], $category->id);
            $category->save();

            return redirect('admin/bussiness/category')->with('success', 'New Bussiness category created successfully');

        }catch(Exception $e)
        {
            return redirect('admin/bussiness/category/create')->with('error', $e->getMessage());
        }
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
        $pageTitle = "Admin - Edit Bussiness Category";
        $category = BussinessCategory::find($id);
        $categories = BussinessCategory::where('parent_id',0)->get();
        return view('admin.categories.edit',compact('pageTitle','category','categories'));
        /*if($id!=1 and $id!=2)
        {
            
        }else
        {
            return redirect('admin/bussiness/category')->with('error', 'You cannot edit this category');
        }*/
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
        $validator = Validator::make($request->all(),BussinessCategory::$updateValidater);

        if ($validator->fails()) {
            return redirect('admin/bussiness/category/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        if ($request->hasFile('category_image') ){
            if ($request->file('category_image') && $request->file('category_image')->isValid()) {
                $old_image = BussinessCategory::whereId($id)->first()->image;
                $file = $key = md5(uniqid(rand(), true));
                $ext = $request->file('category_image')->getClientOriginalExtension();
                $image = $file.'.'.$ext;
                $img = Image::make($request->file('category_image')->getRealPath());

                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                             $constraint->aspectRatio();
                })->save(config('image.category_image_path').'/thumbnails/large/'.$image);

                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                             $constraint->aspectRatio();
                })->save(config('image.category_image_path').'/thumbnails/medium/'.$image);
                
                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.category_image_path').'/thumbnails/small/'.$image);
                $fileName = $request->file('category_image')->move(config('image.category_image_path'), $image);
                $this->deleteImage(config('image.category_image_path'),$old_image);
            } else {
                return redirect('admin/bussiness/category')->with('Error', 'Business Category image is not uploaded.Please try again');
            }
        }
        $input = $request->input();

        /*if($input['title'] == $input['confirm_title'])
        {*/
            $category = array_intersect_key($input, BussinessCategory::$updatable);
           
           
            if(isset($fileName)) {
               $category['image'] =  $image;
                 
                $category = BussinessCategory::where('id',$id)->update($category);
            } else {
                $category = BussinessCategory::where('id',$id)->update($category);
            }
            if($category){
                return redirect('admin/bussiness/category')->with('success', ' Business Category updated successfully');
            }else
            {
                return redirect('admin/bussiness/category')->with('error', ' Error occured.Please Try again!');
            }
        /*} else {
            return back()->with('error', 'Title and confirm title should be same');
        }*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = BussinessCategory::findOrFail($id);

        if($category->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Business Category deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Business Category can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    public function block($id)
    {
        if($id!=1 and $id!=2)
        {    
            $category = BussinessCategory::find($id);
            $category->is_blocked = !$category->is_blocked;
            $category->save();

            if ($category->is_blocked) {
                return redirect('admin/bussiness/category')->with('success', 'Bussiness Category has been blocked successfully');
            } else {
                return redirect('admin/bussiness/category')->with('success', 'Bussiness Category has been unblocked');
            }
        }else
        {
            return redirect('admin/bussiness/category')->with('error', 'You cannot block/unblock this category');
        }
    }

    /**
     * Remove the specified image and thumbnails from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteImage($image_path,$file_name)
    {
        /*if($file_name!=""){
            unlink($image_path.$file_name);
            unlink($image_path.'thumbnails/small/'.$file_name);
            unlink($image_path.'thumbnails/medium/'.$file_name);
            unlink($image_path.'thumbnails/large/'.$file_name);
        }*/
    }
}
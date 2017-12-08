<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Http\Requests;
use App\BusinessProduct;
use App\UserBusiness;
use App\BusinessNotification;
use App\BusinessProductImage;
use App\Helper;
use Auth;
use Validator;
use Image;

class BusinessProductsController extends Controller
{
    /**
     * Author:Divya
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->businessNotification = new BusinessNotification();
        $this->productImages = new BusinessProductImage();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->business->bussiness_category_id <= 2) {
            return redirect('/');
        }

        $pageTitle = "Business Products";
        $products = BusinessProduct::where('user_id',Auth::id())->where('is_blocked',0)->orderBy('created_at','desc')->paginate(10);
        $flag = 0;
        return view('business-product.index', compact('products','pageTitle', 'flag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        if (Auth::user()->business->bussiness_category_id <= 2) {
            return redirect('/');
        }

        $pageTitle = "Business Product -create";
        $flag=0;
        $products = BusinessProduct::where('user_id',Auth::id())->where('is_blocked',0)->paginate(10);
        return view('business-product.create', compact('pageTitle', 'flag'));
        /*if($products->count()>=5)
        {
            return redirect('business-product')->with('warning', 'You have already added 5 products.');
        }else
        {
            return view('business-product.create', compact('pageTitle', 'flag'));
        }*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if (Auth::user()->business->bussiness_category_id <= 2) {
            return redirect('/');
        }

        $input = $request->input(); 
        $validator = Validator::make($request->all(), BusinessProduct::$validater );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $business = UserBusiness::whereUserId(Auth::id())->first();

        $product = new BusinessProduct();

        $product->user_id = Auth::id();
        $product->business_id = $business->id;
        $product->title = $input['title'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->slug = Helper::slug($input['title'], $product->id);

        $product->save();

        $business_product_image['user_id'] = Auth::id();
        $business_product_image['business_id'] = $business->id;
        $business_product_image['business_product_id'] = $product->id;

        if(isset($input['featured_image'])) {
            $featuredImage = explode('.', $input['featured_image']);
            $business_product_image['featured_image'] = $featuredImage[0].'.png';
        }


        $product_image = array_intersect_key($business_product_image, BusinessProductImage::$updatable);
        $product_image = BusinessProductImage::create($product_image);
        $product_image->save();

        //dd($product_image);


        if ($product_image->saveProductImages($request->input())) {
            $source = 'product';
            $this->businessNotification->saveNotification($business->id, $source);
            return redirect('business-product')->with('success', 'New Product created successfully');
        } else {
            return back()->with('Error', 'Product image is not uploaded. Please try again');
        }


        /*if ($request->hasFile('product_image')) {
            $files = $request->file('product_image');
            foreach ($files as $key => $file) {
                if($file->isValid())
                {
                    $business_product_image['image'] = $file;
                    $business_product_image['featured_image'] = 0;

                    $validator = Validator::make($business_product_image, BusinessProductImage::$validater);
                    
                    if ($validator->fails()) {
                        return back()->withErrors($validator)->withInput();
                    }
                    
                    $file2 = md5(uniqid(rand(), true));
                    $extension = $file->getClientOriginalExtension();
                    $img_name = $file2.'.'.$extension;
                    
                    $img = Image::make($file->getRealPath());
                    
                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.product_image_path').'/thumbnails/large/'.$file2.'.'.$extension);
                    
                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.product_image_path').'/thumbnails/medium/'.$file2.'.'.$extension);
                    
                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                         $constraint->aspectRatio();
                    })->save(config('image.product_image_path').'/thumbnails/small/'.$file2.'.'.$extension);
                    
                    $fileName = $file->move(config('image.product_image_path'), $img_name);
                    $business_product_image['image'] = $img_name;
                    
                    if($input['featured_image']-1==$key)
                    {
                        $business_product_image['featured_image'] = 1;
                    }

                    $product_image = array_intersect_key($business_product_image, BusinessProductImage::$updatable);
                    $product_image = BusinessProductImage::create($product_image);
                    $product_image->save();

                }else
                {
                    return back()->with('Error', 'Product image is not uploaded. Please try again');
                }
            }
        }else
        {
            return back()->with('Error', 'Product image is not uploaded. Please try again');
        }*/



        /*$source = 'product';
        $this->businessNotification->saveNotification($business->id, $source);

        return redirect('business-product')->with('success', 'New Product created successfully');*/
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::user()->business->bussiness_category_id <= 2) {
            return redirect('/');
        }

        $pageTitle = "Business Product-View";
        $product = BusinessProduct::find($id);
        $productImages = BusinessProductImage::whereBusinessProductId($id)->get();
        $flag = 0;
        return view('business-product.view',compact('pageTitle','product', 'flag', 'productImages'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->business->bussiness_category_id <= 2) {
            return redirect('/');
        }

        $pageTitle = "Business Product-Edit";
        $product = BusinessProduct::find($id);
        $flag=0;
        $product_images = BusinessProductImage::where('user_id',$product->user_id)->where('business_id',$product->business_id)->where('business_product_id',$product->id)->orderBy('id', 'ASC')->get();
        return view('business-product.edit',compact('pageTitle','product','product_images', 'flag'));
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
        if (Auth::user()->business->bussiness_category_id <= 2) {
            return redirect('/');
        }
        
        $input = $request->input(); 
        $validator = Validator::make($request->all(), BusinessProduct::$validater );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = array_intersect_key($input, BusinessProduct::$updatable);

        $product = BusinessProduct::where('id',$id)->update($product);

        if(isset($input['featured_image'])) {
            $featuredImage = explode('.', $input['featured_image']);
            $input['featured_image'] = $featuredImage[0].'.png';
        }

        $productImages = BusinessProduct::find($id);

        if(Auth::user()->user_role_id == 5) {

            if (isset($input['fileArray'])) {
                $total = ($productImages->business_product_images->image == null) ? 0: count($productImages->business_product_images->images());
                $uploadImages = count(explode(',',$input['fileArray']));
                if(($total+$uploadImages) > 5 )
                {
                    return back()->with('error', 'you cannot upload images greater then 5-$total');
                } else {}


            } else {
                return back()->with('error', 'please upload atleast one image of product');   
            }
        }

        $product_image = array_intersect_key($input, BusinessProductImage::$updatable);

        $productImages = $this->productImages->whereBusinessProductId($id)->update($product_image);

        $productImages = $this->productImages->whereBusinessProductId($id)->first();

        if (isset($input['fileArray']) && $input['fileArray'] !=null && $productImages->saveProductImages($request->input())) {
            return redirect('business-product')->with('success', 'Product updated successfully');
        } else {
            return redirect('business-product')->with('success', 'Product updated successfully');
        }
        /*$input = $request->input();
        BusinessProduct::$updateValidater['featured_image'] = 'required';
        $validator = Validator::make($request->all(),BusinessProduct::$updateValidater);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $product = array_intersect_key($input, BusinessProduct::$updatable);

        $product = BusinessProduct::where('id',$id)->update($product);

        $product = BusinessProduct::where('id',$id)->first();

        $list = BusinessProductImage::where('business_product_id',$id)->pluck('id')->toArray();
        if(count($list)>0){
            foreach (array_intersect($list, $input['product_image_id']) as $key => $value) {
                $product_image = BusinessProductImage::whereId($value)->first();
                $old_image = $product_image->image;
                $product_image->featured_image = 0;

                if($request->hasFile('product_image'))
                {
                    $files = $request->file('product_image');
                    if(isset($files[$value]))
                    {
                        if($files[$value]->isValid())
                        {
                            $file2 = md5(uniqid(rand(), true));
                            $extension = $files[$value]->getClientOriginalExtension();
                            $img_name = $file2.'.'.$extension;
                            
                            $img = Image::make($files[$value]->getRealPath());
                            
                            $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/large/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/medium/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/small/'.$file2.'.'.$extension);
                            
                            $fileName = $files[$value]->move(config('image.product_image_path'), $img_name);
                            $this->deleteImage(config('image.product_image_path'),$old_image);
                            $product_image->image = $img_name;
                            
                        }else
                        {
                            return back()->with('Error', 'Product image is not uploaded. Please try again');
                        }
                    }
                }
                $product_image->save();
            }
            foreach (array_diff($list,$input['product_image_id']) as $value) {
                $product_image = BusinessProductImage::whereId($value)->first();
                $this->deleteImage(config('image.product_image_path'),$product_image->image);
                BusinessProductImage::whereId($value)->delete();
            }
        }
        if(count($request->file('product_image'))>0){
            foreach (array_keys($request->file('product_image')) as $value) {
                $business_product_image['user_id'] = $product->user_id;
                $business_product_image['business_id'] = $product->business_id;
                $business_product_image['business_product_id'] = $product->id;
                $business_product_image['featured_image'] = 0;
                if($request->hasFile('product_image'))
                {
                    $files = $request->file('product_image');
                    if(isset($files[$value]))
                    {
                        if($files[$value]->isValid())
                        {
                            $file2 = md5(uniqid(rand(), true));
                            $extension = $files[$value]->getClientOriginalExtension();
                            $img_name = $file2.'.'.$extension;

                            $img = Image::make($files[$value]->getRealPath());
                        
                            $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/large/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/medium/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.product_image_path').'/thumbnails/small/'.$file2.'.'.$extension);
                            
                            $fileName = $files[$value]->move(config('image.product_image_path'), $img_name);
                            $business_product_image['image'] = $img_name;

                            $product_image = array_intersect_key($business_product_image, BusinessProductImage::$updatable);
                            $product_image = BusinessProductImage::create($product_image);
                            $product_image->save();
                        }else
                        {
                            return back()->with('Error', 'Product image is not uploaded. Please try again');
                        }
                    }
                }
            }
        }
        $product_image = BusinessProductImage::whereId(BusinessProductImage::offset($request->input('featured_image')-1)->limit(1)->where('business_product_id',$id)->pluck('id')->first())->update(array('featured_image'=>1));
        return redirect('business-product')->with('success', 'Product updated successfully');*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = BusinessProduct::findOrFail($id);

        $product_images = BusinessProductImage::where('business_product_id',$id)->first();

        if(isset($product->business_product_images->image))
        {
            foreach ($product->business_product_images->images() as $product_image) {
                $this->deleteImage(config('image.product_image_path'),$product_image);
            }
        }

        if($product->delete() && $product_images->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Product deleted successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Product can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAllImage($id)
    {
        $product = $this->productImages->whereBusinessProductId($id)->first();

        if($product) {
            if(isset($product->business_product_images->image))
            {
                foreach ($product->business_product_images->images() as $product_image) {
                    $this->deleteImage(config('image.product_image_path'),$product_image);
                }
            }   
            if($this->productImages->whereBusinessProductId($id)->update(['image' => '', 'featured_image' => ''])) {   
                return response()->json(['status' => true, 'message' => "Product Images are deleted successfully."]);
            } else {
               return response()->json(['status' => false, 'message' => "Product Images could not be deleted. Kindly try again."]);
            }
        } else {
            return response()->json(['status' => false, 'message' => "Product Images could not be found. It may be removed or there may be some issue."]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id, $image
     * @return \Illuminate\Http\Response
     */
    public function deleteSingleImage($id, $image)
    {   
        $images = BusinessProduct::find($id);

        if (count($images->business_product_images->images()) == 1) {

            $image = $this->productImages->whereBusinessProductId($id)->pluck('image')->first();

            if ($this->productImages->whereBusinessProductId($id)->update(['image' => '', 'featured_image' => ''])) {
                $this->deleteImage(config('image.product_image_path'),$image);
                return response()->json(['status' => true, 'message' => "Product Image is deleted successfully."]);
            } else {
                return response()->json(['status' => false, 'message' => "Product Image could not be deleted. Kindly try again."]);
            }

        } elseif (count($images->business_product_images->images()) <= 5) {

            $images = $this->productImages->whereBusinessProductId($id)->pluck('image')->first();
            $featuredImage = $this->productImages->whereBusinessProductId($id)->pluck('featured_image')->first();

            if ($featuredImage && $image == $featuredImage) {
                $this->productImages->whereBusinessProductId($id)->update(['featured_image' => $images]);
            }

            $imagesArray = explode("|",$images);
            $key = array_search($image, $imagesArray);

            if ($key !== null) {
                unset($imagesArray[$key]);
                $images = implode('|',$imagesArray);

                $this->deleteImage(config('image.product_image_path'),$image);

                if ($this->productImages->whereBusinessProductId($id)->update(['image' => $images])) {
                    return response()->json(['status' => true, 'message' => "Product Image is deleted successfully."]);
                } else {
                    return response()->json(['status' => false, 'message' => "Product Image could not be deleted. Kindly try again."]);
                }
            } else {
                return response()->json(['status' => false, 'message' => "Product Image could not be found. It may be removed or there may be some issue."]);
            }
        } else {
            return response()->json(['status' => false, 'message' => "Product Image could not be found. It may be removed or there may be some issue."]);
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
        if($file_name!=""){
            unlink($image_path.$file_name);
            unlink($image_path.'thumbnails/small/'.$file_name);
            unlink($image_path.'thumbnails/medium/'.$file_name);
            unlink($image_path.'thumbnails/large/'.$file_name);
        }
    }


}
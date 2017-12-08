<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Validator;
use File;
use Image;
use DB;
use App\BusinessProductImage;
use App\BusinessNotification;

class BusinessProduct extends Model
{
	use SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = ['user_id', 'business_id', 'title', 'slug', 'description', 'price'];

    public static $updatable = ['id' => "", 'business_id' => "", 'user_id' => "", 'title' => "", 'slug' => "", 'description' => "", 'price' => ""];

    public static $validater = array(
    	'title' => 'required|max:255',
    	'description' => 'required',
        'price' => 'required|regex:/^\d*(\.\d{2})?$/',
    	);

    public static $updateValidater = array(
    	'title' => 'required',
    	'description' => 'required',
        'price' => 'required|regex:/^\d*(\.\d{2})?$/',
    	);

    public function images()
    {
        return explode('|', $this->image);
    }

    public function product_business()
    {
        return $this->hasOne('App\UserBusiness','user_id');
    }

    public function business_product_images()
    {
        return $this->hasOne('App\BusinessProductImage');
    }

    public function apiGetUserBusinessProducts($input)
    {
        $products = BusinessProduct::select('business_products.*','business_product_images.image as product_images', 'business_product_images.featured_image as featured_images','users.currency')->join('business_product_images','business_products.id','=', 'business_product_images.business_product_id')->join('users','users.id','=','business_products.user_id')->where('business_products.user_id',$input['userId'])->orderBy('updated_at', 'DESC')->skip($input['index'])->take($input['limit'])->get();
        return $products;
    }

    public function apiPostUserProduct(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'userId' => 'required',
            'businessId' => 'required',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'is_featured' => 'required|string',
            /*'productImage' => 'sometimes|required|string',*/
            'productId' => 'sometimes|required|integer',
            'updatedImage' => 'sometimes|required|string',
            'deletedImage' => 'sometimes|required|string',
            'addedImage' => 'sometimes|required|string',
        ]);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        if (isset($input['productId']) and !empty($input['productId'])) {

            $product = BusinessProductImage::whereBusinessProductId($input['productId'])->first();
        
            if ($product) {
                BusinessProductImage::whereBusinessProductId($input['productId'])->update(['featured_image' => $input['is_featured']]);
                /*if(isset($input['deletedImage']) and !empty($input['deletedImage']))
                {
                    $images = BusinessProductImage::whereBusinessProductId($input['productId'])->pluck('image')->first();

                    $imagesArray = explode("|",$images);
                    $key = array_search($input['deletedImage'], $imagesArray);

                    //Helper::removeImages(config('image.product_image_path'),$productImage->image);

                    if ($key !== null) {
                        unset($imagesArray[$key]);
                        $images = implode('|',$imagesArray);

                        if (!BusinessProductImage::whereBusinessProductId($input['productId'])->update(['image' => $images])) {
                            
                            return response()->json(['status' => 'exception','response' => 'Image not Deleted.']);
                        }           
                    }
                }*/

                if(isset($input['addedImage']) and !empty($input['addedImage']))
                {   
                    

                    $data = $input['addedImage'];
                    $data = explode("|", $data);
                    if(count($data)>0)
                    {
                        foreach ($data as $value) {

                            if(File::exists(config('image.temp_image_path').$value))
                            {
                                if(File::move(config('image.temp_image_path').$value, config('image.product_image_path').$value))
                                {
                                    $file = config('image.product_image_path').$value;

                                    $img = Image::make($file);
                        
                                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.product_image_path').'/thumbnails/large/'.$value); 

                                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.product_image_path').'/thumbnails/medium/'.$value);
                                            
                                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.product_image_path').'/thumbnails/small/'.$value);

                                    /*$business_product_image['user_id'] = $input['userId'];
                                    $business_product_image['business_id'] = $input['businessId'];
                                    $business_product_image['business_product_id'] = $product->id;*/
                                    $productImage = BusinessProductImage::whereBusinessProductId($input['productId'])->first();

                                    $image = $productImage->image;

                                    if (empty($productImage->image) || $productImage->image = "" ||$product->image == NULL) {
                                        $business_product_image['image'] = $value; //dd('hello1');
                                    } else { //dd('hello2');
                                        $business_product_image['image'] = $image.'|'.$value;
                                    }
                                    

                                    /*if(!empty($productImage->image) || $productImage->image != "" || $product->image != NULL)
                                        $updatedImage = $productImage->image.$business_product_image['image'];
                                    else
                                        $updatedImage = $business_product_image['image'];*/

                                    
                            
                                    if (!$productImage->update(['image' => $business_product_image['image']]))
                                    {
                                        return response()->json(['status' => 'exception','response' => "Image Cannot be saved. Please try again!"]);
                                    }
                        

                                    
                                    /*$product_image = array_intersect_key($business_product_image, BusinessProductImage::$updatable);
                                    $product_image = BusinessProductImage::create($product_image);
                                    if(!($product_image->save())){
                                        return response()->json(['status' => 'exception','response' => "Image Cannot be saved. Please try again!"]);
                                    }*/
                                }else
                                {
                                    //$this->deleteProduct($product->id);
                                    return response()->json(['status' => 'exception','response' => "Image Cannot be added. Please try again!"]);
                                }
                            } /*else
                                {
                                    //$this->deleteProduct($product->id);
                                    return response()->json(['status' => 'exception','response' => "Image Cannot be added. Please try again!"]);
                                }*/
                        }
                        
                    } else {
                         return response()->json(['status' => 'exception','response' => "Atleast one image is required."]);
                    }
                }

                $product = array_intersect_key($input, BusinessProduct::$updatable);

                $product['user_id'] = $input['userId'];
                $product['id'] = $input['productId'];

                $product = BusinessProduct::where('id', $input['productId'])->where('user_id', $input['userId'])->update($product);
                $image = BusinessProductImage::whereBusinessProductId($input['productId'])->first();
                
                if($product && $image)
                {   
                    if($input['is_featured'] != $image->featured_image ) {
                    $setIsFeatured = BusinessProductImage::whereBusinessProductId($input['productId'])->update(['featured_image' => $input['is_featured']]);
                    //dd($setIsFeatured);

                    if($setIsFeatured)
                    {
                        return response()->json(['status' => 'success','response' => "Product updated successfully."]);
                        
                    }
                    return response()->json(['status' => 'exception','response' => "Featured Image cannot be set.Please try again."]);
                    } else {
                       return response()->json(['status' => 'success','response' => "Product updated successfully."]); 
                    }
                    
                }
                else
                    return response()->json(['status' => 'failure','response' => "Product could not updated successfully.Please try again."]);
            }else
            {
                return response()->json(['status' => 'failure','response' => "Product id is not valid.Please try again."]);
            }
        } else {

            $product = array_intersect_key($request->input(), BusinessProduct::$updatable);
            $product['user_id'] = $input['userId'];
            $product['business_id'] = $input['businessId'];

            $product = BusinessProduct::create($product);
            $product->save();
            
            $product->slug = Helper::slug($product->title, $product->id);

            if($product->save()){
                if(isset($input['addedImage']) && !empty($input['addedImage']))
                {   

                    $data = $input['addedImage'];
                    $data = explode("|", $data);
                    if(count($data)>0)
                    {
                        foreach ($data as $value) {
                            if(File::exists(config('image.temp_image_path').$value))
                            {
                                if(File::move(config('image.temp_image_path').$value, config('image.product_image_path').$value))
                                {
                                    $file = config('image.product_image_path').$value;

                                    $img = Image::make($file);
                        
                                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.product_image_path').'/thumbnails/large/'.$value); 

                                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.product_image_path').'/thumbnails/medium/'.$value);
                                            
                                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.product_image_path').'/thumbnails/small/'.$value);

                                }else
                                {
                                    //$this->deleteProduct($product->id);
                                    return response()->json(['status' => 'exception','response' => "Image Cannot be added. Please try again!"]);
                                }
                            } /*else {
                                return response()->json(['status' => 'exception','response' => "Image Cannot be added. Please try again!"]);
                            }*/
                        }
                        $business_product_image['user_id'] = $input['userId'];
                        $business_product_image['business_id'] = $input['businessId'];
                        $business_product_image['business_product_id'] = $product->id;

                        $productImage = BusinessProductImage::create($business_product_image);
                        if(!$productImage->update(['image' => $input['addedImage'], 'featured_image' => $input['is_featured']]))
                        {
                            return response()->json(['status' => 'exception','response' => "Product Image could not be added"]);
                        }
                        $businessNotification = new BusinessNotification();

                        $source = 'product';
                        $businessNotification->saveNotification($product->business_id, $source);

                        return response()->json(['status' => 'success','response' => "Product added successfully."]);
                    }else
                    {
                         return response()->json(['status' => 'exception','response' => "Atleast one image is required."]);
                    }
                } else
                {
                     return response()->json(['status' => 'exception','response' => "Atleast one image is required."]);
                }

                /*return response()->json(['status' => 'success','response' => $product]);*/
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:Product could not be created .Please try later.']);
            }
        }
    }

    public function deleteProduct($id)
    {
        $product = BusinessProduct::whereId($id)->first();
        if($product)
        {
            $product_images = BusinessProductImage::where('business_product_id',$id)->get();
            foreach ($product_images as $key => $value) {
                Helper::removeImages(config('image.product_image_path'),$value);
            }
            $product->delete();
        }
    }
}
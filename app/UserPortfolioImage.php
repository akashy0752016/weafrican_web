<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\UserBusiness;
use App\UserPortfolio;
use Auth;
use Validator;
use Image;
use File;

class UserPortfolioImage extends Model
{
    protected $mediaTempPath;
    protected $portfolioImagePath;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->mediaTempPath = config('image.media_temp_path');
        $this->portfolioImagePath = config('image.portfolio_image_path');
    }

    protected $fillable = ['user_id', 'business_id', 'user_portfolio_id', 'title', 'description', 'image', 'featured_image'];

    public static $updatable = ['user_id' => "", 'business_id' => "", 'user_portfolio_id' => "", 'title' => "", 'description' => "", 'image' => "", 'featured_image' => ""];
    
    public static $validater = array(
    	'title' => 'required|unique:user_portfolio_images|max:255',
    	'description' => 'required',
        'image' => 'required|image|mimes:jpg,png,jpeg',
    ); 

    public function validate($input, $portfolio = null)
    {
        return Validator::make($input, [
            'title' => 'max:255|required|unique:user_portfolio_images,title,'.(($portfolio != null) ? ($portfolio->id.',id'): 'null,null'.',user_id,'.Auth::id()),
            'description' => 'required',
        ]);
    }

    //function to save and update portfolio images section
    public function savePortfolio($input, $operation, $id = null)
    {
        
        //$input = array_intersect_key($input, $this->updatable);

        if ($operation == 'create') {
            $input['user_id'] = Auth::id();
            $businessId = UserBusiness::whereuserId(Auth::id())->first();
            $input['business_id'] = $businessId->id;
            $portfolioId = UserPortfolio::whereuserId(Auth::id())->first();
            $input['user_portfolio_id'] = $portfolioId->id;
            $input['title'] = $input['title'];
            $input['description'] = $input['description'];
            if(isset($input['featured_image'])) {
                $featuredImage = explode('.', $input['featured_image']);
                $input['featured_image'] = $featuredImage[0].'.png';
            }
            return $this->create(array_filter($input, function($value) {return $value !== '';}));
        } else {
            return $this->whereId($id)->update($input);
        }
    }

    public function images()
    {
        return explode('|', $this->image);
    }

    public function savePortfolioImages($input)
    {
        $fileType = null;
        $portfolio = null;

        $portfolio = $this->saveImage($input);

        return true;
    }

    public function saveImage($input)
    {  
        $fileArray = json_decode($input['fileArray']);

        foreach($fileArray as $key => $file) {
            // get media name without extension
            $uniqueId = current(explode('.', $file));

            if ($this->image == null)
                $this->image = $uniqueId.'.png';
            else
                $this->image = $this->image . '|' . $uniqueId.'.png';

            rename($this->mediaTempPath.'/'.$key.'/'.$file, $this->portfolioImagePath.'/'.$uniqueId.'.png');

            $img = Image::make($this->portfolioImagePath.'/'.$uniqueId.'.png');

            $img->resize(intval(config('image.large_thumbnail_width')), null, function($constraint) {
                 $constraint->aspectRatio();
            });

            $img->save($this->portfolioImagePath.'thumbnails/large/'.$uniqueId.'.png');

            $img->resize(intval(config('image.medium_thumbnail_width')), null, function($constraint) {
                 $constraint->aspectRatio();
            });

            $img->save($this->portfolioImagePath.'thumbnails/medium/'.$uniqueId.'.png');

            $img->resize(intval(config('image.small_thumbnail_width')), null, function($constraint) {
                 $constraint->aspectRatio();
            });

            $img->save($this->portfolioImagePath.'thumbnails/small/'.$uniqueId.'.png');

            $this->save();
        }
    }

    public function apiGetUserPortfolioImages($input)
    {
        $portfolioImages = $this->whereuserPortfolioId($input['portfolioId'])->wherebusinessId($input['businessId'])->whereuserId($input['userId'])->orderBy('created_at', 'DESC')->skip($input['index'])->take($input['limit'])->get();
        return $portfolioImages;
    }

    public function apiPostUserPortfolioDetail(Request $request) 
    {
        $input = $request->input();

        $validator = Validator::make($input, [
            'userId' => 'required',
            'businessId' => 'required',
            'portfolioId' => 'required',
            'portfolioImageId' => 'sometimes|required',
            'title' => 'required',
            'description' => 'required',
            'featuredImage' => 'required|string',
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

        if (isset($input['portfolioImageId']) and !empty($input['portfolioImageId'])) {

            $portfolio = UserPortfolioImage::whereId($input['portfolioImageId'])->first();
        
            if ($portfolio) {

                 $portfolioImage = UserPortfolioImage::whereId($input['portfolioImageId'])->update(['featured_image' => $input['featuredImage']]);
                
                /*if(isset($input['deletedImage']) and !empty($input['deletedImage']))
                {
                    $images = UserPortfolioImage::whereId($input['portfolioImageId'])->pluck('image')->first();

                    $imagesArray = explode("|",$images);
                    $key = array_search($input['deletedImage'], $imagesArray);

                    //Helper::removeImages(config('image.product_image_path'),$productImage->image);

                    if ($key !== null) {
                        unset($imagesArray[$key]);
                        $images = implode('|',$imagesArray);

                        if (!UserPortfolioImage::whereId($input['portfolioImageId'])->update(['image' => $images])) {
                            
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
                                if(File::move(config('image.temp_image_path').$value, config('image.portfolio_image_path').$value))
                                {
                                    $file = config('image.portfolio_image_path').$value;

                                    $img = Image::make($file);
                        
                                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.portfolio_image_path').'/thumbnails/large/'.$value); 

                                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.portfolio_image_path').'/thumbnails/medium/'.$value);
                                            
                                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.portfolio_image_path').'/thumbnails/small/'.$value);

                                    $portfolioImage = UserPortfolioImage::whereId($input['portfolioImageId'])->first();
                                    $image = $portfolioImage->image;

                                    if (empty($portfolioImage->image) || $portfolioImage->image = "" ||$portfolioImage->image == NULL) {
                                        $user_portfolio_image['image'] = $value; 
                                    } else { 
                                        $user_portfolio_image['image'] = $image.'|'.$value;
                                    }

                                    if (!$portfolioImage->update(['image' => $user_portfolio_image['image']]))
                                    {
                                        return response()->json(['status' => 'exception','response' => "Image Cannot be saved. Please try again!"]);
                                    }
                                    /*$product_image = array_intersect_key($business_product_image, BusinessProductImage::$updatable);
                                    $product_image = BusinessProductImage::create($product_image);
                                    if(!($product_image->save())){
                                        return response()->json(['status' => 'exception','response' => "Image Cannot be saved. Please try again!"]);
                                    }*/
                                } /*else {
                                    //$this->deleteProduct($product->id);
                                    return response()->json(['status' => 'exception','response' => "Image Cannot be added. Please try again!"]);
                                }*/
                        } /*else {
                         return response()->json(['status' => 'exception','response' => "Atleast one image is required."]);
                    }*/
                    }
                        
                    }
                }

                if ($portfolio->update(['title' => $input['title'], 'description' => $input['description']])) {
                    return response()->json(['status' => 'success','response' => "Portfolio updated successfully."]);
                } else {
                    return response()->json(['status' => 'failure','response' => "Portfolio could not updated successfully.Please try again."]);
                }
            }else
            {
                return response()->json(['status' => 'failure','response' => "Portfolio id is not valid.Please try again."]);
            }
        } else {
                if(isset($input['addedImage']) && !empty($input['addedImage']))
                {  
                    $data = $input['addedImage'];
                    $data = explode("|", $data);
                    if(count($data)>0)
                    { 
                        foreach ($data as $value) { 
                            //dd($value);
                            if(File::exists(config('image.temp_image_path').$value))
                            {
                                if(File::move(config('image.temp_image_path').$value, config('image.portfolio_image_path').$value))
                                {
                                    $file = config('image.portfolio_image_path').$value;

                                    $img = Image::make($file);
                        
                                    $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.portfolio_image_path').'/thumbnails/large/'.$value); 

                                    $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.portfolio_image_path').'/thumbnails/medium/'.$value);
                                            
                                    $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                         $constraint->aspectRatio();
                                    })->save(config('image.portfolio_image_path').'/thumbnails/small/'.$value);
                                    
                                }
                            } 
                        }
                    }
                        //dd($user_portfolio_image);
                        $portfolio = array_intersect_key($request->input(), UserPortfolioImage::$updatable);
                        $portfolio['user_id'] = $input['userId'];
                        $portfolio['business_id'] = $input['businessId'];
                        $portfolio['user_portfolio_id'] = $input['portfolioId'];

                        $portfolio = UserPortfolioImage::create($portfolio);

                        $portfolioImage = UserPortfolioImage::find($portfolio->id);
                        if ($portfolioImage) { 
                            if (!$portfolio->update(['image' => $input['addedImage'], 'featured_image' => $input['featuredImage']]))
                            {
                            return response()->json(['status' => 'exception','response' => "Image Cannot be saved. Please try again!"]);
                            }
                        } 
                        
                        return response()->json(['status' => 'success','response' => $portfolio]);
                } else {
                    return response()->json(['status' => 'exception','response' => "Atleast one image is required."]);
                }              
            }
    }

    public function apiPostUserPortfolioDetail112(Request $request)
    {
    	$input = $request->input();

    	$rule = array(
    		'userId' => 'required',
            'businessId' => 'required',
            'portfolioId' => 'required',
    		'title' => 'required',
            'description' => 'required',
            'featured_image' => 'integerz'
    	);

    	if(isset($input['portfolioImageId']))
    	{
    		$rule['image'] = 'string';
    	}else
    	{
    		$rule['image'] = 'required|string';
    	}
    	
        $validator = Validator::make($input, $rule);

        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $input['user_id'] = $input['userId'];
    	$input['business_id'] = $input['businessId'];
    	$input['user_portfolio_id'] = $input['portfolioId'];

        if(isset($input['portfolioImageId']))
        {
        	$portfolioImage = $this->whereuserId($input['user_id'])->wherebusinessId($input['business_id'])->whereuserPortfolioId($input['user_portfolio_id'])->whereId($input['portfolioImageId'])->first();
        	if($portfolioImage)
        	{
        		if(isset($input['image']) && !empty($input['image']))
	        	{
	        		$data = $input['image'];

	                $img = str_replace('data:image/jpeg;base64,', '', $data);
	                $img = str_replace(' ', '+', $img);

	                $data = base64_decode($img);

	                $fileName = md5(uniqid(rand(), true));

	                $image = $fileName.'.'.'png';

	                $file = config('image.portfolio_image_path').$image;

	                $success = file_put_contents($file, $data);

	                $img = Image::make($file);
	                    
	                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
	                             $constraint->aspectRatio();
	                        })->save(config('image.portfolio_image_path').'/thumbnails/large/'.$image); 

	                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
	                     $constraint->aspectRatio();
	                })->save(config('image.portfolio_image_path').'/thumbnails/medium/'.$image);
	                        
	                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
	                     $constraint->aspectRatio();
	                })->save(config('image.portfolio_image_path').'/thumbnails/small/'.$image);
	        	}

	        	if($portfolioImage->image!="")
	        	{
	        		if(File::exists(config('image.portfolio_image_path').$portfolioImage->image))
	        		{
	        			File::delete(config('image.portfolio_image_path').$portfolioImage->image);

	        			File::delete(config('image.portfolio_image_path').'/thumbnails/small/'.$portfolioImage->image);

	        			File::delete(config('image.portfolio_image_path').'/thumbnails/medium/'.$portfolioImage->image);

	        			File::delete(config('image.portfolio_image_path').'/thumbnails/large/'.$portfolioImage->image);
	        		}
	        	}

	        	if(isset($image))
	        	{
	        		$input['image'] = $image;
	        	}

	        	$portfolioImage = array_intersect_key($input, UserPortfolioImage::$updatable);

	        	$portfolioImage = $this->whereuserId($input['user_id'])->wherebusinessId($input['business_id'])->whereuserPortfolioId($input['user_portfolio_id'])->whereId($input['portfolioImageId'])->update($portfolioImage);

	        	if($portfolioImage)
	                return response()->json(['status' => 'success','response' => "Portfolio Image has been updated successfully."]);
	            else
	                return response()->json(['status' => 'failure','response' => "Portfolio Image could not updated successfully.Please try again."]);

        	}else
        	{
        		return response()->json(['status' => 'exception','response' => 'portfolio Image dose not exists']);
        	}
        	
        }else
        {
        	if(isset($input['image']) && !empty($input['image']))
        	{
        		$data = $input['image'];

                $img = str_replace('data:image/jpeg;base64,', '', $data);
                $img = str_replace(' ', '+', $img);

                $data = base64_decode($img);

                $fileName = md5(uniqid(rand(), true));

                $image = $fileName.'.'.'png';

                $file = config('image.portfolio_image_path').$image;

                $success = file_put_contents($file, $data);

                $img = Image::make($file);
                    
                $img->resize(config('image.large_thumbnail_width'), null, function($constraint) {
                             $constraint->aspectRatio();
                        })->save(config('image.portfolio_image_path').'/thumbnails/large/'.$image); 

                $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.portfolio_image_path').'/thumbnails/medium/'.$image);
                        
                $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                     $constraint->aspectRatio();
                })->save(config('image.portfolio_image_path').'/thumbnails/small/'.$image);
        	}

            if(isset($image)){
                $input['image'] = $image;
            }

            $portfolioImage = array_intersect_key($input, UserPortfolioImage::$updatable);

            $portfolioImage = UserPortfolioImage::create($portfolioImage);

            if($portfolioImage->save()){
                return response()->json(['status' => 'success','response' => $portfolioImage]);
            } else {
                return response()->json(['status' => 'failure','response' => 'System Error:Portfolio Image could not be added .Please try later.']);
            }
        }
    }

    public function apiRemoveUserPortfolioImages($input)
    {

        $rule = array(
            'user_id' => 'required',
            'business_id' => 'required',
            'user_portfolio_id' => 'required',
            'id' => 'required',
        );

        $validator = Validator::make($input, $rule);
        if($validator->fails()){
            if(count($validator->errors()) <= 1){
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else{
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }
        $portfolioImage = $this->where(function($q) use ($input){
            foreach($input as $key => $value){
                $q->where($key, '=', $value);
            }})
        ->first();
        if($portfolioImage)
        {
            if($portfolioImage->image!="")
            {
                if(File::exists(config('image.portfolio_image_path').$portfolioImage->image))
                {
                    File::delete(config('image.portfolio_image_path').$portfolioImage->image);

                    File::delete(config('image.portfolio_image_path').'/thumbnails/small/'.$portfolioImage->image);

                    File::delete(config('image.portfolio_image_path').'/thumbnails/medium/'.$portfolioImage->image);

                    File::delete(config('image.portfolio_image_path').'/thumbnails/large/'.$portfolioImage->image);
                }
            }
            if($this->find($portfolioImage->id)->forceDelete())
            {
                $portfolioImages = $this->whereuserPortfolioId($input['user_portfolio_id'])->wherebusinessId($input['business_id'])->whereuserId($input['user_id'])->get();
                return response()->json(['status' => 'success','response' => $portfolioImages]);
            }else
            {
                return response()->json(['status' => 'failure','response' => 'System Error:Portfolio Image could not be deleted .Please try later.']);
            }
        }else
        {
            return response()->json(['status' => 'exception','response' => 'User Portfolio Image dos\'nt exists']);
        }
    }
}

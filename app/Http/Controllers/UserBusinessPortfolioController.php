<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\BussinessCategory;
use App\UserBusiness;
use App\CmsPage;
use App\User;
use App\CountryList;
use App\SecurityQuestion;
use App\BussinessSubcategory;
use App\UserPortfolio;
use App\UserPortfolioImage;
use Auth;
use Image;
use Validator;
use App\Helper;
use Session;
use Illuminate\Support\Facades\Hash;

class UserBusinessPortfolioController extends Controller
{
    public function __construct()
    {
        $this->portfolio = new UserPortfolioImage();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        if (Auth::user()->business->bussiness_category_id > 2) {
            return redirect('/');
        }

        $pageTitle = "Business Profile";
        $flag = 0;
        $business = UserBusiness::where('user_id',Auth::id())->first();
        $businessPorfolio = UserPortfolio::where('user_id',Auth::id())->where('business_id',$business->id)->first();
        $portfolio_images = UserPortfolioImage::where('user_id',Auth::id())->where('business_id',$business->id)->orderBy('id', 'desc')->get();
        return view('business-portfolio.edit', compact('business', 'pageTitle', 'businessPorfolio', 'portfolio_images', 'flag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->business->bussiness_category_id > 2) {
            return redirect('/');
        }

        $pageTitle = "Add Portfolio Image";
        $flag = 0;
        return view('business-portfolio.add', compact('pageTitle', 'flag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        if (Auth::user()->business->bussiness_category_id > 2) {
            return redirect('/');
        }

        $validator = $this->portfolio->validate($request->input());

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $portfolio = $this->portfolio->savePortfolio($request->input(),'create');
       
        if ($portfolio->savePortfolioImages($request->input())) {
            return redirect('portfolio')->with('success', 'Portfolio added successfully.');
        }

        return redirect()->back()->with('error', 'Portfolio could not be added. Please try again.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $portfolioImages = UserPortfolioImage::find($id);
        
        $response = view('sections.portfolio-lightbox')->with('portfolioImages', $portfolioImages)->render();
        
        return response()->json(['status' => 'success','response' => $response]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->business->bussiness_category_id > 2) {
            return redirect('/');
        }

        $pageTitle = "Business Portfolio-Edit";
        $portfolio = UserPortfolioImage::find($id);
        $flag = 0;

        return view('business-portfolio.update',compact('pageTitle','portfolio','flag'));
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
        if (Auth::user()->business->bussiness_category_id > 2) {
            return redirect('/');
        }
        
        $input = $request->input();

        if(isset($input['type']) && $input['type'] == 'image') {
            $portfolio = $this->portfolio->whereId($id)->first();
            $validator = $this->portfolio->validate($request->input(), $portfolio);

            if($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            if(isset($input['featured_image'])) {
                $featuredImage = explode('.', $input['featured_image']);
                $input['featured_image'] = $featuredImage[0].'.png';
            }

            $portfolioImage = $portfolio->update($input);
           
            if (isset($input['fileArray']) && $input['fileArray'] != null && $portfolio->savePortfolioImages($request->input())) {
                return redirect('portfolio')->with('success', 'Portfolio updated successfully.');
            }
            if($portfolioImage)
            {
                return redirect('portfolio')->with('success', 'Portfolio updated successfully.');
            }
            return redirect()->back()->with('error', 'Portfolio could not be added. Please try again.');
        }

        /*$portfolio = UserPortfolio::where('user_id',Auth::id())->first();
        $rules = array(
            'maritial_status' => 'required',
            'occupation' => 'required|string',
            'acedimic_status' => 'required',
            'key_skills' => 'required|string',
            'experience_years' => 'required',
            'experience_months' =>'required',
            'height_feets' => 'required',
            'height_inches' => 'required',
            'hair_type' => 'required',
            'hair_color' => 'required',
            'skin_color' => 'required',
            'professional_training' => 'sometimes',
            'institute_name' => 'required_if:professional_training,on',
            
            );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $messages = $validator->messages();
            return back()->withErrors($validator)
                     ->withInput();
        }*/

        $portfolio = array_intersect_key($input, UserPortfolio::$updatable);

        $portfolio = UserPortfolio::where('id',$id)->update($portfolio);

        $portfolio = UserPortfolio::where('id',$id)->first();

        /*$list = UserPortfolioImage::where('user_portfolio_id',$id)->pluck('id')->toArray();

        if(count($list)>0){
            foreach (array_intersect($list, $input['portfolio_image_id']) as $key => $value) {
                $portfolio_image = UserPortfolioImage::whereId($value)->first();
                $old_image = $portfolio_image->image;
                $portfolio_image->title = $input['portfolio_title'][$value];
                $portfolio_image->description = $input['portfolio_description'][$value];
                $portfolio_image->featured_image = 0;

                if($request->hasFile('portfolio_image'))
                {
                    $files = $request->file('portfolio_image');
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
                            })->save(config('image.portfolio_image_path').'/thumbnails/large/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.portfolio_image_path').'/thumbnails/medium/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.portfolio_image_path').'/thumbnails/small/'.$file2.'.'.$extension);
                            
                            $fileName = $files[$value]->move(config('image.portfolio_image_path'), $img_name);
                            $this->deleteImage(config('image.portfolio_image_path'),$old_image);
                            $portfolio_image->image = $img_name;
                            
                        }else
                        {
                            return back()->with('Error', 'Product image is not uploaded. Please try again');
                        }
                    }
                }

                $portfolio_image->save();
            }
            foreach (array_diff($list,$input['portfolio_image_id']) as $value) {
                $portfolio_image = UserPortfolioImage::whereId($value)->first();
                $this->deleteImage(config('image.portfolio_image_path'),$portfolio_image->image);
                UserPortfolioImage::whereId($value)->delete();
            }
        }
        if(count($request->file('portfolio_image'))>0){
            foreach (array_keys($request->file('portfolio_image')) as $value) {
                $business_portfolio_image['user_id'] = $portfolio->user_id;
                $business_portfolio_image['business_id'] = $portfolio->business_id;
                $business_portfolio_image['user_portfolio_id'] = $portfolio->id;
                $business_portfolio_image['title'] = $input['portfolio_title'][$value];
                $business_portfolio_image['description'] = $input['portfolio_description'][$value];
                $business_portfolio_image['featured_image'] = 0;

                if($request->hasFile('portfolio_image'))
                {
                    $files = $request->file('portfolio_image');
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
                            })->save(config('image.portfolio_image_path').'/thumbnails/large/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.medium_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.portfolio_image_path').'/thumbnails/medium/'.$file2.'.'.$extension);
                            
                            $img->resize(config('image.small_thumbnail_width'), null, function($constraint) {
                                 $constraint->aspectRatio();
                            })->save(config('image.portfolio_image_path').'/thumbnails/small/'.$file2.'.'.$extension);
                            
                            $fileName = $files[$value]->move(config('image.portfolio_image_path'), $img_name);
                            $business_portfolio_image['image'] = $img_name;

                            $portfolio_image = array_intersect_key($business_portfolio_image, UserPortfolioImage::$updatable);
                            $portfolio_image = UserPortfolioImage::create($portfolio_image);
                            $portfolio_image->save();
                        }else
                        {
                            return back()->with('Error', 'Portfolio image is not uploaded. Please try again');
                        }
                    }
                }
            }
        }
        /*if(isset($request->input('featured_image')) and !empty($request->input('featured_image')))
        {
            $portfolio_image = UserPortfolioImage::whereId(UserPortfolioImage::offset($request->input('featured_image')-1)->limit(1)->where('user_portfolio_id',$id)->pluck('id')->first())->update(array('featured_image'=>1));
        }*/
        $business = UserBusiness::where('user_id',Auth::id())->update(array('is_update'=>0));
        return redirect('register-business/'.$portfolio->business_id)->with('success', 'Your Portfolio has been updated');        
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portfolio = UserPortfolioImage::findOrFail($id);

        if($portfolio->images())
        {
            foreach ($portfolio->images() as $portfolio_image) {
                $this->deleteImage(config('image.portfolio_image_path'),$portfolio_image);
            }
        }

        if($portfolio->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Portfolio deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Portfolio can not be deleted.Please try again',
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
        $portfolio = $this->portfolio->whereId($id)->first();

        if($portfolio) {
            if(isset($portfolio->image))
                {
                    foreach ($portfolio->images() as $portfolio_image) {
                        $this->deleteImage(config('image.portfolio_image_path'),$portfolio_image);
                    }
                } 
            if($this->portfolio->whereId($id)->update(['image' => '', 'featured_image' => ''])) {
                      
                return response()->json(['status' => true, 'message' => "Portfolio Images are deleted successfully."]);
            } else {
               return response()->json(['status' => false, 'message' => "Portfolio Images could not be deleted. Kindly try again."]);
            }
        } else {
            return response()->json(['status' => false, 'message' => "Portfolio Images could not be found. It may be removed or there may be some issue."]);
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
        $images = UserPortfolioImage::find($id);

        if (count($images->images()) == 1) {
            $images = UserPortfolioImage::whereId($id)->pluck('image')->first();
            $this->deleteImage(config('image.portfolio_image_path'), $image);

            if (UserPortfolioImage::whereId($id)->update(['image' => '', 'featured_image' => ''])) {
                
                return response()->json(['status' => true, 'message' => "Portfolio Image is deleted successfully."]);
            } else {
                return response()->json(['status' => false, 'message' => "Portfolio Image could not be deleted. Kindly try again."]);
            }

        } elseif (count($images->images()) <= 5) {
            $images = UserPortfolioImage::whereId($id)->pluck('image')->first();
            $featuredImage = UserPortfolioImage::whereId($id)->pluck('featured_image')->first();

            if ($featuredImage && $image == $featuredImage) {
                UserPortfolioImage::whereId($id)->update(['featured_image' => $images]);
            }

            $imagesArray = explode("|",$images);
            $key = array_search($image, $imagesArray);

            if ($key !== null) {
                unset($imagesArray[$key]);
                $images = implode('|',$imagesArray);

                $this->deleteImage(config('image.portfolio_image_path'),$image);

                if (UserPortfolioImage::whereId($id)->update(['image' => $images])) {
                    return response()->json(['status' => true, 'message' => "Portfolio Image is deleted successfully."]);
                } else {
                    return response()->json(['status' => false, 'message' => "Portfolio Image could not be deleted. Kindly try again."]);
                }
            } else {
                return response()->json(['status' => false, 'message' => "Portfolio Image could not be found. It may be removed or there may be some issue."]);
            }
        } else {
            return response()->json(['status' => false, 'message' => "Portfolio Image could not be found. It may be removed or there may be some issue."]);
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

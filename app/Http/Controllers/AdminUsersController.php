<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\User;
use App\BussinessCategory;
use App\BussinessSubCategory;
use App\UserBusiness;
use Auth;
use Validator;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Users';
        $users = User::whereIn('user_role_id',array(3,4,5))->orderBy('created_at', 'DESC')->get();
        $flag=0;
        return view('admin.users.index', compact('pageTitle', 'users', 'flag'));
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
        $input = $request->input();
         $validator = Validator::make($request->all(), [
            'title' => 'required',
            'keywords' =>'required',
            'bussiness_category_id' =>'required',
            'keywords' =>'required',
            'email' => 'required|email|max:255|unique:users,id,'.$input['id'],
            'mobile_number' => 'required|numeric|unique:users,id,'.$input['id'],
            'pin_code' => 'required|string',
            'country' => 'string',
            'state' => 'string',
            'city' => 'string',
            'business_logo' => 'image|mimes:jpg,png,jpeg,gif',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                         ->withInput();
        }

        if ($request->hasFile('business_logo') ){
            if ($request->file('business_logo')->isValid())
            {
                $file = $key = md5(uniqid(rand(), true));
                $ext = $request->file('business_logo')->
                    getClientOriginalExtension();
                $image = $file.'.'.$ext; 

                $fileName = $request->file('business_logo')->move(config('image.logo_image_path'), $image);

                $command = 'ffmpeg -i '.config('image.logo_image_path').$image.' -vf scale='.config('image.logo_small_thumbnail_width').':-1 '.config('image.logo_image_path').'thumbnails/small/'.$image;
                shell_exec($command);
            }
        }
        $user_input = array_intersect_key($input, User::$updatable);
        $user_input['user_role_id'] = 3;
        User::where('id',$input['id'])->update($user_input);
        $user = User::where('id', $input['id'])->first();

        $business = array_intersect_key($input, UserBusiness::$updatable);

        $business['business_id']=substr($user->first_name,0,3).rand(0,999);
        $business['user_id'] = $user->id;
        $business['is_agree_to_terms'] = 1;

        if(isset($fileName)){
            $business['business_logo'] = $image;
        }
        if($business['bussiness_subcategory_id']=="")
        {
            unset($business['bussiness_subcategory_id']);
        }
        $business = UserBusiness::create($business);
        $business->save();

        if($business)
        {
            return redirect('admin/users')->with('success', 'User Business created successfully.'); 
               
        } else {
            return back()->with('error', 'User business could not be created.Please try again');
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
        $pageTitle = "Admin - Add Bussiness user";
        $user = User::find($id);

        $categories = BussinessCategory::where('is_blocked', 0)->get();
        $flag=0;
        return view('admin.users.create', compact('pageTitle', 'categories', 'user', 'flag'));
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = 'Admin - Edit User';
        $user = User::find($id);
        $flag=0;
        return view('admin.users.edit', compact('pageTitle', 'user', 'flag'));
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
        $user = User::find($id);

        $input = array_intersect_key($request->input(), User::$updatable);

        if ($user->update($input)) {
            return redirect('admin/users')->with('success', 'Information of User:'.$user->id.' has been updated.');
        } else {
            return redirect('admin/users')->with('error', 'Information of User:'.$user->id.' has not been updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->delete()){
            $response = array(
                'status' => 'success',
                'message' => ' User deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => ' User can not be deleted.Please try again',
            );
        }
        return json_encode($response);
    }

    public function block($id)
    {
        $user = User::find($id);
        $user->is_blocked = !$user->is_blocked;
        $user->save();
       
        if($user->is_blocked){ 
            return redirect('admin/users')->with('success', 'User blocked successfully');
        } else { 
            return redirect('admin/users')->with('success', 'User unblocked successfully');
        }   
    }

    public function getSearch(Request $request=null)
    {
        $input = $request->input();
        $user_condition = array();
        $business_condition = array();
        if(isset($input['status']) && $input['status']!="")
        {
            $status = $input['status'];
        }
        if($input['country']!="")
        {
            $user_condition['country'] = $input['country'];
        }
        if($input['state']!="")
        {
            $user_condition['state'] = $input['state'];
        }
        if($input['city']!="")
        {
            $user_condition['city'] = $input['city'];
        }
        if(isset($input['type']) && $input['type']!=""){
            $user_condition['user_role_id'] = $input['type'];
            $type = $input['type'];
        }
        if(isset($input['category']) && $input['category']!="")
        {
            $business_condition['bussiness_category_id'] = $input['category'];
        }
        if(isset($input['subcategory']) && $input['subcategory']!="")
        {
            $business_condition['bussiness_subcategory_id'] = $input['subcategory'];
        }
        if($input['page']=='user')
        {
            if(!empty($request->country) || !empty($request->state) || !empty($request->city || !empty($request->type)))
            {
                $users = User::where($user_condition)->get();
            }else
            {
                $users = User::whereIn('user_role_id',array(3,4))->get();
            }
            $pageTitle = 'Admin - Users';
            $countries = User::distinct('country')->whereNotNull('country')->where('country','!=',"")->pluck('id','country')->toArray();
            $states = User::where('country',$input['country'])->whereNotNull('state')->where('state','!=',"")->distinct('state')->pluck('state');
            $cities = User::where('country',$input['country'])->where('state',$input['state'])->whereNotNull('city')->where('city','!=',"")->distinct('city')->pluck('city');
            /*$categories = BussinessCategory::where('is_blocked', 0)->orderBy('id','asc')->pluck('id', 'title');
            $subcategories = BussinessSubCategory::whereCategoryId($input['category'])->where('is_blocked', 0)->orderBy('id','asc')->pluck('title', 'id');*/
            $flag=0;
            return view('admin.users.index', compact('pageTitle', 'users','countries','states','cities','input', 'flag', 'type'));
        } elseif ($input['page'] == 'premium') {
            if(!empty($request->country) || !empty($request->state) || !empty($request->city) || !empty($request->category) || !empty($request->subcategory ))
            {   $user_condition['user_role_id'] = 5;
                $user_ids = User::where($user_condition)->pluck('id');
                //dd($user_ids);
                if(isset($status))
                {
                    switch ($status) {
                        case '0':
                            $businesses = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->where('is_identity_proof_validate', 0)->where('is_business_proof_validate', 0)->get();
                            break;
                        
                        case '1':
                            $businesses = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->where('is_identity_proof_validate', 1)->where('is_business_proof_validate', 1)->get();
                            break;

                        default:
                            $businesses = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->get();
                            break;
                    }
                }else
                {
                    $businesses = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->get();
                }
                
            }else
            {
                if(isset($status))
                {
                    switch ($status) {
                        case '0':
                            $businesses = UserBusiness::where('is_identity_proof_validate', 0)->where('is_business_proof_validate', 0)->get();
                            break;
                        
                        case '1':
                            $businesses = UserBusiness::where('is_identity_proof_validate', 1)->where('is_business_proof_validate', 1)->get();
                            break;

                        default:
                            $businesses = UserBusiness::get();
                            break;
                    }
                }else
                {
                    $businesses = UserBusiness::get();
                }
            }
            $pageTitle = 'Admin - Premium User Business';
            $countries = User::distinct('country')->whereNotNull('country')->where('country','!=',"")->pluck('id','country')->toArray();
            $states = User::where('country',$input['country'])->whereNotNull('state')->where('state','!=',"")->distinct('state')->pluck('state');
            $cities = User::where('country',$input['country'])->where('state',$input['state'])->whereNotNull('city')->where('city','!=',"")->distinct('city')->pluck('city');
            $categories = BussinessCategory::where('is_blocked', 0)->orderBy('id','asc')->pluck('id', 'title');
            if(isset($status))
            {
                $status = "";
            }
            if(isset($input['category']) && $input['category']!="")
            {
                $subcategories = BussinessCategory::where('parent_id',$input['category'])->where('is_blocked', 0)->orderBy('id','asc')->pluck('id', 'title');
            }
            return view('admin.premium-business.index', compact('pageTitle', 'businesses','countries','states','cities','input','categories','subcategories','status'));
        } else {
            if(!empty($request->country) || !empty($request->state) || !empty($request->city) || !empty($request->category) || !empty($request->subcategory || !empty($request->type)))
            {
                $user_ids = User::where($user_condition)->pluck('id');
                if(isset($status))
                {
                    switch ($status) {
                        case '0':
                            $businesses = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->where('is_identity_proof_validate', 0)->where('is_business_proof_validate', 0)->get();
                            break;
                        
                        case '1':
                            $businesses = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->where('is_identity_proof_validate', 1)->where('is_business_proof_validate', 1)->get();
                            break;

                        default:
                            $businesses = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->get();
                            break;
                    }
                }else
                {
                    $businesses = UserBusiness::where($business_condition)->whereIn('user_id',$user_ids)->get();
                }
                
            }else
            {
                if(isset($status))
                {
                    switch ($status) {
                        case '0':
                            $businesses = UserBusiness::where('is_identity_proof_validate', 0)->where('is_business_proof_validate', 0)->get();
                            break;
                        
                        case '1':
                            $businesses = UserBusiness::where('is_identity_proof_validate', 1)->where('is_business_proof_validate', 1)->get();
                            break;

                        default:
                            $businesses = UserBusiness::get();
                            break;
                    }
                }else
                {
                    $businesses = UserBusiness::get();
                }
            }
            $pageTitle = 'Admin - User Business';
            $countries = User::distinct('country')->whereNotNull('country')->where('country','!=',"")->pluck('id','country')->toArray();
            $states = User::where('country',$input['country'])->whereNotNull('state')->where('state','!=',"")->distinct('state')->pluck('state');
            $cities = User::where('country',$input['country'])->where('state',$input['state'])->whereNotNull('city')->where('city','!=',"")->distinct('city')->pluck('city');
            $categories = BussinessCategory::where('is_blocked', 0)->orderBy('id','asc')->pluck('id', 'title');
            if(isset($status))
            {
                $status = "";
            }
            if(isset($input['category']) && $input['category']!="")
            {
                $subcategories = BussinessCategory::where('parent_id',$input['category'])->where('is_blocked', 0)->orderBy('id','asc')->pluck('id', 'title');
            }
            return view('admin.business.index', compact('pageTitle', 'businesses','countries','states','cities','input','categories','subcategories','status', 'type'));
        }
    }

    public function exportToCsv(Request $request)
    {
        $input = $request->input();
        $condition = array();
        if($input['country']!="")
        {
            $condition['users.country'] = $input['country'];
        }
        if($input['state']!="")
        {
            $condition['users.state'] = $input['state'];
        }
        if($input['city']!="")
        {
            $condition['users.city'] = $input['city'];
        }
        if(isset($input['category']) && $input['category']!="")
        {
            $condition['user_businesses.bussiness_category_id'] = $input['category'];
        }
        if(isset($input['subcategory']) && $input['subcategory']!="")
        {
            $condition['user_businesses.bussiness_subcategory_id'] = $input['subcategory'];
        }
        if(isset($input['status']) and $input['status']!="")
        {
            if($input['status']==0)
            {
                $condition['user_businesses.is_identity_proof_validate'] = 0;
                $condition['user_businesses.is_business_proof_validate'] = 0;
            }elseif($input['status']==1)
            {
                $condition['user_businesses.is_identity_proof_validate'] = 1;
                $condition['user_businesses.is_business_proof_validate'] = 1;
            }
        }
        if($input['page']=='user')
        {
            if(!empty($request->country) || !empty($request->state) || !empty($request->city) || !empty($request->category) || !empty($request->subcategory))
            {
                $users = User::select('users.first_name','users.middle_name','users.last_name','users.email','users.country_code','users.mobile_number','users.city','users.state','users.country','user_businesses.title','user_businesses.business_id','bussiness_categories.title as category_title')
                ->join('user_businesses', 'user_businesses.user_id', '=', 'users.id')
                ->join('bussiness_categories', 'bussiness_categories.id', '=', 'user_businesses.bussiness_category_id')
                ->where($condition)
                ->get()->toArray();
            }else
            {
                $users = User::select('users.first_name','users.middle_name','users.last_name','users.email','users.country_code','users.mobile_number','users.city','users.state','users.country','user_businesses.title','user_businesses.business_id','bussiness_categories.title as category_title')
                ->join('user_businesses', 'user_businesses.user_id', '=', 'users.id')
                ->join('bussiness_categories', 'bussiness_categories.id', '=', 'user_businesses.bussiness_category_id')
                ->get()->toArray();
            }
        }elseif($input['page']=='business')
        {
            if(!empty($request->country) || !empty($request->state) || !empty($request->city) || !empty($request->category) || !empty($request->subcategory))
            {
                $users = UserBusiness::select('users.first_name','users.middle_name','users.last_name','users.email','users.country_code','users.mobile_number','users.city','users.state','users.country','user_businesses.title','user_businesses.business_id','bussiness_categories.title as category_title')
                ->join('users','users.id','=','user_businesses.user_id')
                ->join('bussiness_categories','user_businesses.bussiness_category_id', '=', 'bussiness_categories.id')
                ->where($condition)
                ->get()->toArray();
            }else
            {
                $users = UserBusiness::select('users.first_name','users.middle_name','users.last_name','users.email','users.country_code','users.mobile_number','users.city','users.state','users.country','user_businesses.title','user_businesses.business_id','bussiness_categories.title as category_title')
                ->join('users','users.id','=','user_businesses.user_id')
                ->join('bussiness_categories','user_businesses.bussiness_category_id', '=', 'bussiness_categories.id')
                ->get()->toArray();
            }
        }
        $header = array('First_Name','Middle_Name','Last_Name','Email','Country_Code', 'Mobile_Number','City','State','Country','Business_Title','Business_Id','Category');
        $delimiter=",";

        $filename = "export".time().".csv";

        header('Content-Type: application/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        $f = fopen('php://output', 'w');
        fputcsv($f, $header, $delimiter);

        foreach ($users as $line) { 
            // generate csv lines from the inner arrays
            fputcsv($f, $line, $delimiter); 
        }
    }
} 
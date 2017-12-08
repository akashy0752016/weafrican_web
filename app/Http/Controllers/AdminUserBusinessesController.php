<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\UserBusiness;
use App\BussinessCategory;
use App\User;

class AdminUserBusinessesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - User Business';
        $businesses = UserBusiness::orderBy('created_at', 'DESC')->get();
        return view('admin.business.index', compact('pageTitle', 'businesses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
        $pageTitle = "Admin - View Bussiness user";
        $business = UserBusiness::find($id);
        return view('admin.business.view',compact('pageTitle','business'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = "Admin - Edit User Bussiness Category";
        $business = UserBusiness::find($id);
        $categories = BussinessCategory::where('is_blocked',0)->where('parent_id',0)->get();
        $subCategories = BussinessCategory::where('parent_id',$business->bussiness_category_id)->where('is_blocked',0)->get();
        return view('admin.business.edit',compact('pageTitle','business', 'categories', 'subCategories'));
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

        $input = $request->input();
        
        $business = array_intersect_key($input, UserBusiness::$updatable);
        $business = UserBusiness::where('id',$id)->update($business);
        $business = UserBusiness::find($id);

        $user = array_intersect_key($input, User::$updatable);
        $user = User::where('id',$business->user_id)->update($user);
            
        return redirect('admin/business')->with('success', 'User Business :'.$business->title.' updated successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = UserBusiness::findOrFail($id);

        if($user->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Business user deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Business user can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    public function block($id)
    {
        $business = UserBusiness::find($id);
        $business->is_blocked = !$business->is_blocked;
        $business->save();

        if ($business->is_blocked) {
            return redirect('admin/business')->with('success', 'User Bussiness has been blocked successfully');
        } else {
            return redirect('admin/business')->with('success', 'User Bussiness has been unblocked');
        }
    }

    public function identityProofVerfied($id)
    {
        $business = UserBusiness::find($id);
        $business->is_identity_proof_validate = ! $business->is_identity_proof_validate;
        $business->save();

        if ( $business->is_identity_proof_validate) {
            return redirect('admin/business/'.$id)->with('success', 'Identity  Proof verfied successfully');
        } else {
            return redirect('admin/business/'.$id)->with('success', 'Identity  Proof verfied successfully');
        }
    }

    public function businessProofVerfied($id)
    {
        $business = UserBusiness::find($id);
        $business->is_business_proof_validate = ! $business->is_business_proof_validate;
        $business->save();

        if ( $business->is_business_proof_validate) {
            return redirect('admin/business/'.$id)->with('success', 'Business  Proof verfied successfully');
        } else {
            return redirect('admin/business/'.$id)->with('success', 'Business  Proof verfied successfully');
        }
    }

    public function businessUserVerify($id)
    {
        $business = UserBusiness::find($id);
        $business->is_business_proof_validate = ! $business->is_business_proof_validate;
        $business->is_identity_proof_validate = ! $business->is_identity_proof_validate;
        $business->save();

        if ( $business->is_business_proof_validate and $business->is_identity_proof_validate) {
            return redirect('admin/business/'.$id)->with('success', 'Business  User has been successfully verified');
        } else {
            return redirect('admin/business/'.$id)->with('success', 'Business  User has been successfully unverified');
        }
    }

    /**
     * Display a listing of the unapproved business list.
     *
     * @return \Illuminate\Http\Response
     */
    public function unapproved()
    {
        $pageTitle = 'Admin - Unapproved Business';
        $businesses = UserBusiness::where('is_identity_proof_validate',0)->where('is_business_proof_validate',0)->orderBy('created_at', 'desc')->get();
        return view('admin.business.unapproved', compact('pageTitle', 'businesses'));
    }
}

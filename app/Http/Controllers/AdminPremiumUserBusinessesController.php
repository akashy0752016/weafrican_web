<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserBusiness;
use App\BussinessCategory;
use App\User;

class AdminPremiumUserBusinessesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Premium User Business';
        $userIds = User::where('user_role_id', 5)->pluck('id');
        $businesses = UserBusiness::whereIn('user_id', $userIds)->get();
        return view('admin.premium-business.index', compact('pageTitle', 'businesses'));
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
        $pageTitle = "Admin - View Premium User Bussiness";
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
                'message' => 'Premium User Business deleted successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Premium User Business can not be deleted.Please try again',
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
            return redirect('admin/premium-business')->with('success', 'Premium User Bussiness has been blocked successfully');
        } else {
            return redirect('admin/premium-business')->with('success', 'Premium User Bussiness has been unblocked');
        }
    }
}

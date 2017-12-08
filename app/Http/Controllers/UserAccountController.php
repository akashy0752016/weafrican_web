<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserAccountDetail;
use App\UserBusiness;
use Validator;
use Auth;

class UserAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $flag = 0;
        $account = UserAccountDetail::whereUserId(Auth::id())->first();

        if (count($account) > 0) {
            $pageTitle = "Weafricans- Bank Account Details";
            return view('my-account.account-details', compact('pageTitle', 'account', 'flag'));
        } else {
            $pageTitle = "Weafricans- Add Bank Account Details";
            //get Bank Name from paystack
            $url = 'https://api.paystack.co/bank';

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(
              $ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer ".config('paystack.secretKey').""]
            );
            $request = curl_exec($ch);
            curl_close($ch);

            if ($request) {
              $bankNames = json_decode($request, true);
            }
            return view('my-account.account-details-add', compact('pageTitle', 'bankNames', 'flag'));   
        }
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
        $validator = Validator::make($request->all(), UserAccountDetail::$validater );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->input();

        $businessName = UserBusiness::whereUserId(Auth::id())->first();
        $account = new UserAccountDetail();

        $account->user_id = Auth::id();
        $account->account_holder_name = $input['account_holder_name'];
        $account->account_number = $input['account_number'];
        $account->bank_name = $input['bank_name'];
        $account->business_name = $businessName->title;
        $account->percentage_charge = 10;

        $response =$this->createSubaccount($account, 'create');
        $account->subaccount_code = $response['data']['subaccount_code'];
        $account->is_verified = $response['data']['is_verified'];
        $account->active = $response['data']['active'];
       
        if($account->save()) {
            return redirect('account-details')->with('success', 'Bank account details added successfully');
        } else {
          return redirect('account-details')->with('error', 'Please enter correct bank account details');  
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
        $flag = 0;
        $pageTitle = "Weafricans-Bank Account Details";
        $account = UserAccountDetail::find($id);
        return view('account-details', compact('pageTitle', 'account', 'flag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageTitle = "Weafricans-Edit Bank Account Details";
        $flag = 0;
        $account = UserAccountDetail::find($id);

        //get Bank Name from paystack
        $url = 'https://api.paystack.co/bank';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
          $ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ".config('paystack.secretKey').""]
        );
        $request = curl_exec($ch);
        curl_close($ch);

        if ($request) {
          $bankNames = json_decode($request, true);
        }
        
        return view('my-account.account-details-edit', compact('pageTitle', 'account', 'flag', 'bankNames'));
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
        $validator = Validator::make($request->all(),UserAccountDetail::$validater);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $businessName = UserBusiness::whereUserId(Auth::id())->first();
        $input = $request->input();
        $input['business_name'] = $businessName->title;
        $input['percentage_charge'] = 10;
        
        $response = $this->createSubaccount($input, 'update');
        $input['subaccount_code'] = $response['data']['subaccount_code'];
        $input['is_verified'] = $response['data']['is_verified'];
        $input['active'] = $response['data']['active'];

        $input = array_intersect_key($input, UserAccountDetail::$updatable);

        $account = UserAccountDetail::where('id',$id)->update($input);
      

        return redirect('account-details')->with('success', 'Bank account updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //create subaccount on paystack
    public function createSubaccount($data, $status)
    { 
        $result = array();
        //The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/subaccount';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
          $ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer ".config('paystack.secretKey')."",
            "Content-Type:application/json"]
        );
        if ($status == 'create') {
            curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($data->toArray()));  
        } else {
            curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $request = curl_exec($ch);
        curl_close($ch);

        if ($request) {
          $result = json_decode($request, true);
        }
        //dd($result);
        return $result;   
    }
}

<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\UserAccountDetail;
use App\UserBusiness;
use Validator;

class UserAccountController extends Controller
{
    /**
     * Function: to get user account details.
     * Url: api/v2/get/user-account/details
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'userId' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
        }

        $response = UserAccountDetail::whereUserId($input['userId'])->first();

        if (count($response) > 0)
            return response()->json(['status' => 'success','response' => $response]);
        else
            return response()->json(['status' => 'exception','response' => 'Could not find user account details.Please try again']);

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
     * Function: to add/update user account details.
     * Url: api/v2/user-account
     * Request type: Post
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->input();

        $validator = Validator::make($input, [
                'id' => 'sometimes|required',
                'userId' => 'required|integer',
                'accountHolderName' => 'required',
                'accountNumber' => 'required',
                'bankName' => 'required',
        ]);

        if ($validator->fails()) {
            if (count($validator->errors()) <= 1) {
                    return response()->json(['status' => 'exception','response' => $validator->errors()->first()]);   
            } else {
                return response()->json(['status' => 'exception','response' => 'All fields are required']);   
            }
        }

        $user = User::find($request->userId);

        $businessName = UserBusiness::whereUserId($request->userId)->first();
        
        if (isset($input['id']) && $input['id'] != null) {
            $account = UserAccountDetail::find($input['id']); 
           
            if($account){
                $userAccount = array_intersect_key($request->input(), UserAccountDetail::$updatable);

                $userAccount['user_id'] = $input['userId'];
                $userAccount['account_holder_name'] = $input['accountHolderName'];
                $userAccount['account_number'] = $input['accountNumber'];
                $userAccount['bank_name'] = $input['bankName'];
                $userAccount['business_name'] = $businessName->title;

                $userAccount['percentage_charge'] = 10;

                $response =$this->createSubaccount($userAccount);
                $userAccount['subaccount_code'] = $response['data']['subaccount_code'];
                $userAccount['is_verified'] = $response['data']['is_verified'];
                $userAccount['active'] = $response['data']['active'];

                $userAccount = UserAccountDetail::whereId($input['id'])->update($userAccount);

                if ($userAccount)
                    return response()->json(['status' => 'success','response' => 'User account details updated successfully.']);
                else
                    return response()->json(['status' => 'exception','response' => 'User account details can be updated successfully.Please try again.']);
            }
            
        } else {
            
            $userAccount = array_intersect_key($request->input(), UserAccountDetail::$updatable);

            $userAccount['user_id'] = $input['userId'];
            $userAccount['account_holder_name'] = $input['accountHolderName'];
            $userAccount['account_number'] = $input['accountNumber'];
            $userAccount['bank_name'] = $input['bankName'];

            $userAccount['business_name'] = $businessName->title;

            $userAccount['percentage_charge'] = 10;

            $response =$this->createSubaccount($userAccount);
            $userAccount['subaccount_code'] = $response['data']['subaccount_code'];
            $userAccount['is_verified'] = $response['data']['is_verified'];
            $userAccount['active'] = $response['data']['active'];

            $userAccount = UserAccountDetail::create($userAccount);

            if ($userAccount->save())
                return response()->json(['status' => 'success','response' => $userAccount]);
            else
                return response()->json(['status' => 'exception','response' => 'Could not save User account details.Please try again.']);
        }
    }


    //create subaccount on paystack
    public function createSubaccount($data)
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
       
        curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($data));
        
        $request = curl_exec($ch);
        curl_close($ch);

        if ($request) {
          $result = json_decode($request, true);
        }
        //dd($result);
        return $result;   
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
        //
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
        //
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
}

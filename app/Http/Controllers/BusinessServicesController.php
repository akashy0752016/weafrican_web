<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Requests;
use App\BusinessService;
use App\UserBusiness;
use App\BusinessNotification;
use App\Helper;
use Validator;
use Auth;


class BusinessServicesController extends Controller
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
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Business Services";
        $services = BusinessService::where('user_id',Auth::id())->where('is_blocked',0)->paginate(10);
        $flag=0;
        return view('business-service.index', compact('services','pageTitle', 'flag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Business Service -create";
        $flag=0;
        return view('business-service.create', compact('pageTitle', 'flag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), BusinessService::$validater );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->input();

        $business = UserBusiness::whereUserId(Auth::id())->first();

        $service = new BusinessService();

        $service->user_id = Auth::id();
        $service->business_id = $business->id;
        $service->title = $input['title'];
        $service->description = $input['description'];
        $service->slug = Helper::slug($input['title'], $service->id);

        $service->save();

        $source = 'service';
        $this->businessNotification->saveNotification($business->id, $source);

        return redirect('business-service')->with('success', 'New Service created successfully');
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
        $pageTitle = "Business Service-Edit";
        $service = BusinessService::find($id);
        $flag=0;
        return view('business-service.edit',compact('pageTitle','service', 'flag'));
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
        $validator = Validator::make($request->all(),BusinessService::$updateValidater);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->input();

        $input = array_intersect_key($input, BusinessService::$updatable);

        $service = BusinessService::where('id',$id)->update($input);
      

            return redirect('business-service')->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = BusinessService::findOrFail($id);

        if($service->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Service deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Service can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\BusinessService;
use Auth;

class AdminBusinessServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Service';
        $services = BusinessService::select('business_services.*', 'user_businesses.id as businessId','user_businesses.business_id', 'user_businesses.title as business_name')->leftJoin('user_businesses','business_services.user_id' , '=', 'user_businesses.user_id')->orderBy('business_services.created_at', 'DESC')->get();
        return view('admin.services.index', compact('pageTitle', 'services'));
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

    public function block($id)
    {
        $service = BusinessService::find($id);
        $service->is_blocked = !$service->is_blocked;
        $service->save();

        if ($service->is_blocked) {
            return redirect('admin/service')->with('success', 'Service has been blocked successfully');
        } else {
            return redirect('admin/service')->with('success', 'Service has been unblocked');
        }
    }
}

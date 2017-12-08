<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\EventSeatingPlan;
use App\Helper;
use Validator;

class AdminSeatingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Seating Plan';
        $seatingplans = EventSeatingPlan::get();
        return view('admin.seating-plan.index', compact('pageTitle', 'seatingplans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = "Admin - Create Event Seating Plan";
        return view('admin.seating-plan.create', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), EventSeatingPlan::$validater );
        if ($validator->fails()) {
            return redirect('admin/seating-plan/create')->withErrors($validator)->withInput();
        }

        $input = $request->input();

        try{
            $seatingplan = new EventSeatingPlan();
            $seatingplan->title = $input['title'];
            $seatingplan->description = $input['description'];
            $seatingplan->slug = Helper::slug($input['title'], $seatingplan->id);

            $seatingplan->save();

            return redirect('admin/seating-plan')->with('success', 'New Event Seating Plan created successfully');
        }catch(Exception $e){
            return redirect('admin/seating-plan/create')->with('error', $e->getMessage());
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
        $pageTitle = "Admin - Edit Event Seating Plan";
        $seatingplan = EventSeatingPlan::find($id);
        return view('admin.seating-plan.edit',compact('pageTitle','seatingplan'));
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
        $validator = Validator::make($request->all(),EventSeatingPlan::$updateValidater);

        if ($validator->fails()) {
            return redirect('admin/seatingplan/'.$id.'/edit')->withErrors($validator)->withInput();
        }
        $input = $request->input();
        try{

            $seatingplan = array_intersect_key($input, EventSeatingPlan::$updatable);
            $seatingplan = EventSeatingPlan::where('id',$id)->update($seatingplan);

            return redirect('admin/seating-plan')->with('success', ' Event Seating Plan updated successfully');
        }catch(Exception $e)
        {
            return back()->with('error', 'There is some error. Please try after some time');
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
        /*$category = EventSeatingPlan::findOrFail($id);

        if($category->forceDelete()){
            $response = array(
                'status' => 'success',
                'message' => 'Event Seating Plan deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Event Seating Plan can not be deleted.Please try again',
            );
        }

        return json_encode($response);*/
    }

    /**
     * Block the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function block($id)
    {
        $seatingplan = EventSeatingPlan::find($id);
        $seatingplan->is_blocked = !$seatingplan->is_blocked;
        $seatingplan->save();

        if ($seatingplan->is_blocked) {
            return redirect('admin/seating-plan')->with('success', 'Event Seating Plan has been blocked successfully');
        } else {
            return redirect('admin/seating-plan')->with('success', 'Event Seating Plan has been unblocked');
        }
    }
}

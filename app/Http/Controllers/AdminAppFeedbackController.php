<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\AppFeedback;

class AdminAppFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Service';
        $feedbacks = AppFeedback::select('app_feedbacks.*', 'users.first_name', 'users.middle_name', 'users.last_name', 'users.mobile_number', 'users.country_code')->leftJoin('users','app_feedbacks.user_id' , '=', 'users.id')->get();
        return view('admin.app-feedback.index', compact('pageTitle', 'feedbacks'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedback = AppFeedback::findOrFail($id);

        if($feedback->delete()){
            $response = array(
                'status' => 'success',
                'message' => 'Feedback deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Feedback can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    public function block($id)
    {
       	$feedback = AppFeedback::find($id);
        $feedback->is_blocked = !$feedback->is_blocked;
        $feedback->save();

        if ($feedback->is_blocked) {
            return back()->with('success', 'Feedback has been blocked successfully');
        } else {
            return back()->with('success', 'Feedback has been unblocked');
        }
    }
}
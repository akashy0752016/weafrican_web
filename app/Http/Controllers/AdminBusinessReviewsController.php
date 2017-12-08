<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\BusinessReview;
use App\UserBusiness;

class AdminBusinessReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Admin - Review';
        $businesses = UserBusiness::get();
        return view('admin.reviews.index', compact('pageTitle', 'businesses'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageTitle = 'Admin - View Reviews';
        $reviews = BusinessReview::where('business_id', $id)->get();
        return view('admin.reviews.view', compact('pageTitle', 'reviews'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $review = BusinessReview::findOrFail($id);

        if($review->forceDelete()){
            $response = array(
                'status' => 'success',
                'message' => 'Review deleted  successfully',
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Review can not be deleted.Please try again',
            );
        }

        return json_encode($response);
    }

    public function block($id)
    {
        $review = BusinessReview::find($id);
        $review->is_blocked = !$review->is_blocked;
        $review->save();

        if ($review->is_blocked) {
            return back()->with('success', 'Review has been blocked successfully');
        } else {
            return back()->with('success', 'Review has been unblocked');
        }
    }
}
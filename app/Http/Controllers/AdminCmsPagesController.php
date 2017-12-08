<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\CmsPage;

class AdminCmsPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cmsPages = CmsPage::get();
        $pageTitle = 'Weafricans - Admin';

        return view('admin.cms.index', compact('cmsPages', 'pageTitle'));
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
        $cmsPage = CmsPage::find($id);
        $pageTitle = 'Weafricans - Edit ' . $cmsPage->title;

        return view('admin.cms.edit', compact('cmsPage', 'pageTitle'));
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

        $cmsPage = CmsPage::find($id);

        if(!$cmsPage) {
            return back()->with('error', "Sorry, could not update page's content.");
        }

        if(isset($input['is_show_on_mobile']))
            $input['is_show_on_mobile'] = 1;
        else
            $input['is_show_on_mobile'] = 0;

        $cmsPage->content = $input['content'];
        $cmsPage->is_show_on_mobile = $input['is_show_on_mobile'];

        if($cmsPage->save()) {
            return redirect('admin/cms')->with('success', $cmsPage->title . ' updated successfully.');
        } else {
            return back()->with('error', $cmsPage->title . ' could not be updated successfully.');
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
        //
    }
}

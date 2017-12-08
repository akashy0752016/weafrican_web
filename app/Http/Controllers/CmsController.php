<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\CmsPage;

class CmsController extends Controller
{
    public function index($slug)
    {
    	$cmsPage = CmsPage::where('slug', $slug)->first();
    	$pageTitle = $cmsPage->title;
        $flag = 0;
    	return view('cms.index', compact('cmsPage', 'pageTitle' , 'flag'));
    }

    //get cms pages for mobile view
    public function getCmsPage($slug)
    {
    	$cmsPage = CmsPage::where('slug', $slug)->first();
    	$pageTitle = $cmsPage->title;
        $cmsFlag = 1;
    	return view('cms.index', compact('cmsPage', 'pageTitle' , 'cmsFlag'));
    }
}

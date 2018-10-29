<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    /**
     * Show the contact us page.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactUs()
    {
        return view('comroads-pages.contact-us');
    }
    
    /**
     * Show the about us page.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {
        return view('comroads-pages.about-us');
    }
    
    /**
     * Show the terms and conditions page.
     *
     * @return \Illuminate\Http\Response
     */
    public function termsAndConditions()
    {
        return view('comroads-pages.terms-and-conditions');
    }

    /**
     * Show the uploading rules page.
     *
     * @return \Illuminate\Http\Response
     */
    public function uploadingRules()
    {
        return view('comroads-pages.uploading-rules');
    }

    /**
     * Show the faq page.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq()
    {
        return view('comroads-pages.faq');
    }

    /**
     * Explainer video page
     * 
     * @return \Illuminate\Http\Response
     */
    public function explainerVideo()
    {
        return view('comroads-pages.explainer-video');
    }
    public function lander()
    {
        return view('comroads-pages.lander');
    }
    /**
     * Dashcams page
     * 
     * @return \Illuminate\Http\Response
     */
    public function dashcams()
    {
        return view('comroads-pages.dashcams');
    }
    public function dashcamreview($slug)
    {
        return view('comroads-pages.dashcam-review.' . $slug);
    }
    /**
     * Blog page
     *
     * @return \Illuminate\Http\Response
     */
    public function blog()
    {
        return view('comroads-pages.blog');
    }

    public function blogpost($slug){
        return view('comroads-pages.blogposts.' . $slug);
    }
}




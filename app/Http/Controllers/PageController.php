<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        app(\App\Services\SEOService::class)
            ->set('title', __('About Gamesiano'))
            ->set('description', __('Learn more about Gamesiano, our mission, and the interactive gaming experiences we create.'));

        return view('pages.about');
    }

    public function contact()
    {
        app(\App\Services\SEOService::class)
            ->set('title', __('Contact Us'))
            ->set('description', __('Get in touch with the Gamesiano team for support, feedback, or inquiries.'));

        return view('pages.contact');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function disclaimer()
    {
        return view('pages.disclaimer');
    }
}

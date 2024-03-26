<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
//        $events = Event::visible()
//            ->public()
//            ->coming()
//            ->active()
//            ->orderBy('start', 'asc')
//            ->withTransports()
//            ->withTargets()
//            ->withTravels()
//            ->take(15)
//            ->get();
//        $data = [
//            'is_home' => true,
//            'events' => $events,
//            'title' => __('seo.event_title'),
//            'description' => __('seo.hp_description')
//        ];
//        return view('front.index', $data);


        $proba = [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ];

        return Inertia::render('Front/Index', $proba);
    }

    public function page($url)
    {
//        $page = Page::where([
//            ['url', $url],
//            ['published', 1],
//        ])->first();
//        if (!$page)
//            abort(404);
//        $breadcrumbs = [
//            [
//                'route' => 'home',
//                'name' => __('main.home')
//            ], [
//                'name' => $page->name
//            ]
//        ];
//        $data = [
//            'page' => $page,
//            'breadcrumbs' => $breadcrumbs,
//            'title' => $page->texts->meta_title,
//            'description' => $page->texts->meta_description,
//        ];
//        return view('front.page', $data);
        return Inertia::render('Front/Page');
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $events = Event::visible()
            ->public()
            ->coming()
            ->active()
            ->orderBy('start', 'asc')
            ->withTransports()
            ->withTargets()
            ->withTravels()
            ->take(15)
            ->get();
        $data = [
            'is_home' => true,
            'events' => $events,
            'title' => __('seo.event_title'),
            'description' => __('seo.hp_description')
        ];
        return view('front.index', $data);
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
        dd('222');
    }
}

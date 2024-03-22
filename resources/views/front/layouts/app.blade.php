@vite([
    'resources/front/sass/libs.scss',
])

    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    @if(isset($title))
        <meta name="og:title" content="{{ $title }}">
    @endif
    <link rel="icon" href="{{ url('images/favicon.svg') }}" sizes="any" type="image/svg+xml">
    @if(isset($description))
        <meta name="description" content="{{ $description }}">
        <meta name="og:description" content="{{ $description }}">
    @endif

    <meta name="og:image" content="{{ url('images/favicon.svg') }}">

{{--        <link href="{{ asset('/front/css/libs.css') }}" rel="stylesheet">--}}
{{--        @if(isset($styles))--}}
{{--            @foreach($styles as $style)--}}
{{--                <link href="{{ asset($style) }}" rel="stylesheet">--}}
{{--            @endforeach--}}
{{--        @endif--}}
    <meta name="mailru-domain" content="aq1WJG3T6ppjGgh5"/>
    @routes
</head>
<body class="body">
<header class="header @if(isset($is_home)) header_home header_fixed @endif">
    <div class="container">
        <div class="flex flex-v-center">
            <div class="col0 header__col1 top-logo">
                @if(!isset($is_home))
                    <a class="block" href="{{ route('home') }}">
                        @include('front.layouts.logo')
                    </a>
                @else
                    @include('front.layouts.logo')
                @endif
            </div>
            <div class="col0 flex-full header__col2">
                <nav>
                    <div class="body-shadow"></div>
                    <div class="menu-block">
                        <div class="menu-burger">
                            <svg>
                                <use xlink:href="#ico-menu"></use>
                            </svg>
                        </div>
                        <div class="menu-wrap">
                            <div class="menu-close">
                                <svg>
                                    <use xlink:href="#ico-close"></use>
                                </svg>
                            </div>

                            <ul class="header__ul flex-full">
                                {{--                                @foreach(menu_top() as $item)--}}
                                {{--                                    <li><a href="{{ $item['url'] }}"--}}
                                {{--                                           class="link link-black fz20 fw500">{{ $item['name'] }}</a></li>--}}
                                {{--                                @endforeach--}}
                                @auth
                                    @if(auth()->user()->unread_messages)
                                        <li>
                                            <a class="top-messages link link-black relative"
                                               href="{{ localizedUrl('/account/chats') }}">
                                                <svg width="1.2rem" height="1.2rem" class="block">
                                                    <use xlink:href="#ico-mail"></use>
                                                </svg>
                                                <span
                                                    class="top-messages__counter">{{ auth()->user()->unread_messages }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endauth
                            </ul>
                            <div class="show-768">
                                <div class="mb40"></div>
                                @guest
                                    @if (Route::has('login'))
                                        <a class="link link-black fz20"
                                           href="{{ route('login') }}">{{ __('auth.login') }}</a>

                                    @endif
                                @else
                                    @include('front.common.account_inner')
                                @endguest
                            </div>
                        </div>

                    </div>
                </nav>
            </div>
            <div class="col0 header__col3">
                <div class="flex">
                    {{--                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)--}}
                    {{--                        @if($localeCode != App::getLocale())--}}
                    {{--                            <div class="col0">--}}
                    {{--                                <a class="link link-black fz17 ttu fw500" rel="alternate" hreflang="{{ $localeCode }}"--}}
                    {{--                                   href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">--}}
                    {{--                                    {{ $localeCode }}--}}
                    {{--                                </a>--}}
                    {{--                            </div>--}}
                    {{--                        @endif--}}
                    {{--                    @endforeach--}}
                </div>
            </div>
            <div class="col0 hide-768">
                @guest
                    @if (Route::has('login'))
                        <a class="link link-black fz20" href="{{ route('login') }}">{{ __('auth.login') }}</a>

                    @endif
                @else
                    <div class="account-menu">
                        <button class="link link-black fz20 header__account account-menu__trigger">
                            <img src="{{ url(auth()->user()->ava_top) }}" alt="">
                            {{ auth()->user()->showname }}
                        </button>
                        <div class="account-menu__wrap">
                            @include('front.common.account_inner')
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>
<main class="main" id="app">
    <div>
        @if(!isset($is_home))
            @include('front.common.breadcrumbs')
        @endif
        @yield('content')
    </div>
</main>

<footer class="footer">
    <div class="container">
        <div class="flex flex-wrap-768">
            <div class="col3 col12-768 mb40 footer__col1">
                <div class="mb20 footer__logo">
                    @include('front.layouts.logo')
                </div>
                <p class="fz14 lh13">
                    {{ __('main.disclaim') }}
                    {{--                    <a href="{{ localizedUrl('/info/terms') }}" class="link link-blue">{{ __('main.disclaim2') }}</a>--}}
                </p>
            </div>
            <div class="col3 col6-768 mb40">
                {{--                <ul>--}}
                {{--                    @foreach(menu_bottom(1) as $item)--}}
                {{--                        <li class="mb10"><a href="{{ $item['url'] }}"--}}
                {{--                                            class="link link-black fz16 fw500">{{ $item['name'] }}</a></li>--}}
                {{--                    @endforeach--}}
                {{--                </ul>--}}
                {{--            </div>--}}
                {{--            <div class="col3 col6-768 mb40">--}}
                {{--                <ul>--}}
                {{--                    @foreach(menu_bottom(2) as $item)--}}
                {{--                        <li class="mb10"><a href="{{ $item['url'] }}"--}}
                {{--                                            class="link link-black fz16 fw500">{{ $item['name'] }}</a></li>--}}
                {{--                    @endforeach--}}
                {{--                </ul>--}}
                {{--            </div>--}}
                {{--            <div class="col3 col12-768 mb40">--}}
                {{--                <ul>--}}
                {{--                    @foreach(menu_bottom(3) as $item)--}}
                {{--                        <li class="mb10"><a href="{{ $item['url'] }}"--}}
                {{--                                            class="link link-black fz16 fw500">{{ $item['name'] }}</a></li>--}}
                {{--                    @endforeach--}}
                {{--                </ul>--}}
            </div>
        </div>
    </div>
</footer>
<script>
    let locale = '{{ App::getLocale() }}',
        error_403 = '{{ __('main.error_403') }}',
        error_bug = '{{ __('main.error_bug') }}',
        error_autocomplete = '{{ __('main.error_autocomplete') }}',
        error_not_found = '{{ __('main.error_not_found') }}';
</script>
<script src="{{ asset('/front/js/libs.js') }}"></script>
@if(isset($scripts))
    @foreach($scripts as $script)
        <script src="{{ asset($script) }}"></script>
    @endforeach
@endif
<div class="ajax-loader"></div>

@include('front.layouts.svg')
@include('front.layouts.metrics')
<div class="copied-wrap">
    <div class="copied">
        <div class="copied__svg">
            <svg xmlns="http://www.w3.org/2000/svg" width="9.721" height="6.615" viewBox="0 0 9.721 6.615">
                <g transform="translate(0 0)">
                    <g>
                        <path
                            d="M132.671,165.6a.757.757,0,0,0-1.071-.028l-4.836,4.586-2.306-2.368a.757.757,0,0,0-1.085,1.057l2.828,2.9a.758.758,0,0,0,1.064.021l5.378-5.1A.757.757,0,0,0,132.671,165.6Z"
                            transform="translate(-123.158 -165.364)" fill="#b5ffc4"></path>
                    </g>
                </g>
            </svg>
        </div>
        <div class="copied__span fz14 fw700 ttu">{{ __('main.copied') }}</div>
        <a href="#" class="copied__close color-white fz14 fw700 ttu">OK</a>
    </div>
</div>
</body>
</html>

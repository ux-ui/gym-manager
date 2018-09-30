<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')
    <link rel="manifest" href="{{ asset('mix-manifest.json') }}">
    <title>{{ isset($title) ? "$title | " : '' }}{{ Setting::get('gym.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('style')
</head>
<body>
@auth
<nav class="flex items-center justify-between flex-wrap bg-black p-6">
    <div class="flex items-center flex-no-shrink text-white mr-10">
        <span class="font-semibold text-xl tracking-tight">
            {{ Setting::get('gym.name') }}
        </span>
    </div>
    <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
        <div class="text-sm lg:flex-grow">
            @if ($currentUser->is_admin)
                <a href="{{ route('setting') }}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-teal-lighter mr-4">기본설정</a>
                <a href="{{ route('branch.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-teal-lighter mr-4">지점관리</a>
                <a href="{{ route('user.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-teal-lighter mr-4">직원관리</a>
            @endif
            <a href="{{ route('member.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-teal-lighter mr-4">회원관리</a>
            <a href="{{ route('ledger.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-teal-lighter mr-4">장부관리</a>
            <a href="{{ route('statistics.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-teal-lighter mr-4">통계분석</a>
            <a href="{{ route('attendance.index') }}" class="block mt-4 lg:inline-block lg:mt-0 text-white hover:text-teal-lighter mr-4">출결관리</a>
        </div>
        <div>
            <span class="block mt-4 lg:inline-block lg:mt-0 text-white mr-4">
                <b>{{ $currentUser->name }} {{ $currentUser->title }}</b>
            </span>
        </div>
    </div>
</nav>
@endauth
<div class="content my-5 mx-5">
    @yield('content')
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/fusioncharts@3.12.2/fusioncharts.js" charset="utf-8"></script>
@stack('script')
</body>
</html>

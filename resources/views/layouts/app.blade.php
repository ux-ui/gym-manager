<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @stack('meta')
    <link rel="manifest" href="{{ asset('mix-manifest.json') }}">
    <title>{{ isset($title) ? "$title | " : '' }}{{ Setting::get('gym.name') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('vendors/iconfonts/simple-line-icon/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/iconfonts/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.addons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('style')
</head>
<body>
<div class="container-scroller">
@auth
<nav class="navbar horizontal-layout col-lg-12 col-12 p-0">
    <div class="nav-top flex-grow-1">
        <div class="container d-flex flex-row h-100 align-items-center">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center">
                <span style="color: #fff;">{{ Setting::get('gym.name') }}</span>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-between flex-grow-1">
                <ul class="navbar-nav navbar-nav-right mr-0 ml-auto">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link d-inline-block" href="#">
                            <span class="font-weight-bold text-light">{{ $currentUser->name }} {{ $currentUser->title }}</span> 님
                        </a>
                        <a class="nav-link d-inline-block" style="color: #fff; font-weight: bold; margin-left: 5px;" href="#" onclick="event.preventDefault(); $('#logout-form').submit();">
                            로그아웃
                        </a>
                        <form action="{{ route('logout') }}" method="post" id="logout-form" class="d-none invisible">
                            @csrf
                        </form>
                    </li>
                </ul>
                <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="nav-bottom">
        <div class="container">
            <ul class="nav page-navigation">
                @if ($currentUser->is_admin)
                <li class="nav-item">
                    <a href="{{ route('setting') }}" class="nav-link {{ active('setting*') }}"><i class="link-icon icon-screen-desktop"></i><span class="menu-title">기본설정</span></a>
                </li>
                <li class="nav-item mega-menu">
                    <a href="{{ route('branch.index') }}" class="nav-link {{ active('branch.*') }}"><i class="link-icon icon-screen-desktop"></i><span class="menu-title">지점관리</span></a>
                </li>
                <li class="nav-item mega-menu">
                    <a href="{{ route('user.index') }}" class="nav-link {{ active('user.*') }}"><i class="link-icon icon-screen-desktop"></i><span class="menu-title">직원관리</span></a>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('member.index') }}" class="nav-link {{ active('member.*') }}"><i class="link-icon icon-screen-desktop"></i><span class="menu-title">회원관리</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('ledger.index') }}" class="nav-link {{ active('ledger.*') }}"><i class="link-icon icon-screen-desktop"></i><span class="menu-title">장부관리</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('statistics.index') }}" class="nav-link {{ active('statistics.*') }}"><i class="link-icon icon-screen-desktop"></i><span class="menu-title">통계분석</span></a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('attendance.index') }}" class="nav-link {{ active('attendance.*') }}"><i class="link-icon icon-screen-desktop"></i><span class="menu-title">출결관리</span></a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endauth
<div class="container-fluid page-body-wrapper">
    <div class="main-panel">
    @yield('content')
    </div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/fusioncharts@3.12.2/fusioncharts.js" charset="utf-8"></script>
<script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('vendors/js/vendor.bundle.addons.js') }}"></script>
<script src="{{ asset('js/template.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('script')
</body>
</html>

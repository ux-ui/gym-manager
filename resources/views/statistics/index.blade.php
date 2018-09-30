@title('통계분석')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        <a href="{{ route('statistics.show', ['member_registration', 'yearly']) }}">연도별 회원등록 지표</a>
        <a href="{{ route('statistics.show', ['member_registration', 'monthly']) }}">월별 회원등록 지표</a>
        <a href="{{ route('statistics.show', ['member_registration', 'daily']) }}">일별 회원등록 지표</a>
    </div>
@endsection

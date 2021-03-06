@title('통계분석')
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                        <h5>회원등록 지표 보기</h5>
                        <a href="{{ route('statistics.show', ['member_registration', 'yearly']) }}">연도별 회원등록 지표</a>
                        <a href="{{ route('statistics.show', ['member_registration', 'monthly']) }}">월별 회원등록 지표</a>
                        <a href="{{ route('statistics.show', ['member_registration', 'daily']) }}">일별 회원등록 지표</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                        <h5>회원 출석률 지표 보기</h5>
                        {{--
                        <a href="{{ route('statistics.show', ['member_attendance', 'yearly']) }}">연도별 회원 출석률 지표</a>
                        <a href="{{ route('statistics.show', ['member_attendance', 'monthly']) }}">월별 회원 출석률 지표</a>
                         --}}
                        <a href="{{ route('statistics.show', ['member_attendance', 'daily']) }}">일별 회원 출석률 지표</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                        <h5>지점별 수입지출 내역 보기</h5>
                        <a href="{{ route('statistics.show', ['ledger', 'yearly']) }}">연도별 수입지출 지표</a>
                        <a href="{{ route('statistics.show', ['ledger', 'monthly']) }}">월별 수입지출 지표</a>
                        <a href="{{ route('statistics.show', ['ledger', 'daily']) }}">일별 수입지출 지표</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

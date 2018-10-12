@title('회원관리')
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                        <div class="menu_info bg_fcfcfc">
                            <div class="btn_area text-right">
                                <a class="btn btn-primary" href="{{ route('member.create') }}">회원등록</a>
                            </div>
                        </div>
                        <table class="table">
                            <colgroup>
                                <col width="50">
                                <col width="100">
                                <col>
                                <col width="150">
                                <col width="150">
                            </colgroup>
                            <thead>
                            <tr>
                                <th>번호</th>
                                <th>지점명</th>
                                <th>회원명</th>
                                <th>등록일</th>
                                <th>비고</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($members as $member)
                                <tr>
                                    <td>{{ number($members, $loop) }}</td>
                                    <td class="text-center">{{ $member->branch->name }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td class="text-center">{{ $member->regdate }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-default" href="{{ route('member.show', [$member]) }}">보기</a>
                                        <a class="btn btn-sm btn-default" href="{{ route('member.edit', [$member]) }}">수정</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $members->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

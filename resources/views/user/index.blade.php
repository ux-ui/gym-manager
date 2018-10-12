@title('직원관리')
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
                                <a href="{{ route('user.create') }}" class="btn btn-primary">직원등록</a>
                            </div>
                        </div>
                        <table class="table">
                            <colgroup>
                                <col width="50">
                                <col>
                                <col>
                                <col>
                                <col>
                                <col width="150">
                                <col width="150">
                            </colgroup>
                            <thead>
                            <tr>
                                <th class="text-center">번호</th>
                                <th class="text-center">아이디</th>
                                <th class="text-center">이름</th>
                                <th class="text-center">직책</th>
                                <th class="text-center">지점</th>
                                <th class="text-center">생성일</th>
                                <th class="text-center">비고</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">{{ number($users, $loop) }}</td>
                                    <td class="text-center">{{ $user->username }}</td>
                                    <td class="text-center">{{ $user->name }}</td>
                                    <td>{{ $user->title }}</td>
                                    <td class="text-center">{!! $user->branches->implode('name', ',') !!}</td>
                                    <td class="text-center">{{ $user->_created_at }}</td>
                                    <td class="text-center">
                                        <div class="btn-group-sm">
                                            <a class="btn btn-sm btn-default" href="{{ route('user.edit', [$user]) }}">수정</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

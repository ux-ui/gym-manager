@title('직원관리')
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                        <table class="table table-bordered">
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
                                    <td class="text-center">{!! $user->branches->implode('name', '<br>') !!}</td>
                                    <td class="text-center">{{ $user->_created_at }}</td>
                                    <td class="text-center">
                                        <div class="btn-group-sm">
                                            <a class="btn btn-sm btn-primary" href="{{ route('user.edit', [$user]) }}">수정</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                        <div class="text-right">
                            <a class="btn btn-primary" href="{{ route('user.create') }}">직원등록</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

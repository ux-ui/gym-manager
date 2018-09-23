@title('직원관리')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        <table class="table">
            <thead>
            <tr>
                <th>번호</th>
                <th>아이디</th>
                <th>이름</th>
                <th>직책</th>
                <th>생성일</th>
                <th>비고</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ number($users, $loop) }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->title }}</td>
                    <td>{{ $user->_created_at }}</td>
                    <td>
                        <a href="{{ route('user.show', [$user]) }}">보기</a>
                        <a href="{{ route('user.edit', [$user]) }}">수정</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <a href="{{ route('user.create') }}">직원생성</a>
        </div>
        {{ $users->links() }}
    </div>
@endsection

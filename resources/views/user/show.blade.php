@title('직원정보')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        <table>
            <tbody>
            <tr>
                <th>아이디</th>
                <td>{{ $user->username }}</td>
            </tr>
            <tr>
                <th>이름</th>
                <td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>직책</th>
                <td>{{ $user->title }}</td>
            </tr>
            <tr>
                <th>생성일</th>
                <td>{{ $user->_created_at }}</td>
            </tr>
            </tbody>
        </table>
        <div class="text-right">
            <a href="{{ route('user.index') }}">목록</a>
            <a href="{{ route('user.edit', [$user]) }}">수정</a>
            <form method="POST" action="{{ route('user.destroy', [$user]) }}">
                @csrf
                @method('DELETE')
                <button type="submit">삭제</button>
            </form>
        </div>
    </div>
@endsection

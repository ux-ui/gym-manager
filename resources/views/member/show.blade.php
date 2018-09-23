@title('회원정보')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        <table>
            <tbody>
            <tr>
                <th>회원명</th>
                <td>{{ $member->name }}</td>
            </tr>
            <tr>
                <th>지점명</th>
                <td>{{ $member->branch->name }}</td>
            </tr>
            <tr>
                <th>생성일</th>
                <td>{{ $member->_created_at }}</td>
            </tr>
            </tbody>
        </table>
        <div class="text-right">
            <a href="{{ route('member.index') }}">목록</a>
            <a href="{{ route('member.edit', [$member]) }}">수정</a>
            <form method="POST" action="{{ route('member.destroy', [$member]) }}">
                @csrf
                @method('DELETE')
                <button type="submit">삭제</button>
            </form>
        </div>
    </div>
@endsection

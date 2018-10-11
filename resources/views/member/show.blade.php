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
                <th>주소</th>
                <td>{{ $member->address }}</td>
            </tr>
            <tr>
                <th>체중</th>
                <td>{{ $member->weight }}</td>
            </tr>
            <tr>
                <th>신장</th>
                <td>{{ $member->height }}</td>
            </tr>
            <tr>
            <tr>
                <th>생년월일</th>
                <td>{{ $member->bdate }}</td>
            </tr>
            <tr>
                <th>등록일</th>
                <td>{{ $member->regdate }}</td>
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

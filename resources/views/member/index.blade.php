@title('회원관리')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        @include('_partials.filters', ['action' => route('member.index')])
        <table class="table">
            <thead>
            <tr>
                <th>번호</th>
                <th>회원명</th>
                <th>지점명</th>
                <th>생성일</th>
                <th>비고</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($members as $member)
                <tr>
                    <td>{{ number($members, $loop) }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->branch->name }}</td>
                    <td>{{ $member->_created_at }}</td>
                    <td>
                        <a href="{{ route('member.show', [$member]) }}">보기</a>
                        <a href="{{ route('member.edit', [$member]) }}">수정</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <a href="{{ route('member.create') }}">회원생성</a>
        </div>
        {{ $members->links() }}
    </div>
@endsection

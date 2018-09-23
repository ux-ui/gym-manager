@title('지점관리')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        <table class="table">
            <thead>
            <tr>
                <th>번호</th>
                <th>지점명</th>
                <th>생성일</th>
                <th>비고</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($branches as $branch)
                <tr>
                    <td>{{ number($branches, $loop) }}</td>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->_created_at }}</td>
                    <td>
                        <a href="{{ route('branch.show', [$branch]) }}">보기</a>
                        <a href="{{ route('branch.edit', [$branch]) }}">수정</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <a href="{{ route('branch.create') }}">지점생성</a>
        </div>
        {{ $branches->links() }}
    </div>
@endsection

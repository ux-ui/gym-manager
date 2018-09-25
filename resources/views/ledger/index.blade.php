@title('장부관리')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        @include('_partials.filters', ['action' => route('ledger.index')])
        <table class="table">
            <colgroup>
                <col width="50">
                <col width="50">
                <col width="100">
                <col width="*">
                <col width="150">
                <col width="150">
                <col width="100">
            </colgroup>
            <thead>
            <tr>
                <th class="text-center">번호</th>
                <th class="text-center">지점</th>
                <th class="text-center">구분</th>
                <th class="text-center">금액(원)</th>
                <th class="text-left">내용</th>
                <th class="text-center">생성자</th>
                <th class="text-center">생성일</th>
                <th class="text-center">비고</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($ledgers as $ledger)
                <tr>
                    <td class="text-center">{{ number($ledgers, $loop) }}</td>
                    <td class="text-center">
                        <span>{{ $ledger->branch->name }}</span>
                    </td>
                    <td class="text-center">
                        @if ($ledger->type === '+')
                            <span class="text-red font-bold">{{ $ledger->_type }}</span>
                        @else
                            <span class="text-blue font-bold">{{ $ledger->_type }}</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <span>{{ $ledger->_amount }}</span>
                    </td>
                    <td>{{ $ledger->purpose }}</td>
                    <td class="text-center">{{ $ledger->user->name }} {{ $ledger->user->title }}</td>
                    <td>{{ $ledger->_created_at }}</td>
                    <td>
                        <a href="{{ route('ledger.show', [$ledger]) }}">보기</a>
                        <a href="{{ route('ledger.edit', [$ledger]) }}">수정</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right">
            <a href="{{ route('ledger.create') }}">추가</a>
        </div>
        {{ $ledgers->links() }}
    </div>
@endsection

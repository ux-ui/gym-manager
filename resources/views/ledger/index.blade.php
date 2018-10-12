@title('장부관리')
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
                                <a class="btn btn-primary" href="{{ route('ledger.create') }}">내역추가</a>
                            </div>
                        </div>
                        @include('_partials.filters', ['action' => route('ledger.index')])
                        <table class="table">
                            <colgroup>
                                <col width="50">
                                <col width="100">
                                <col width="80">
                                <col>
                                <col>
                                <col width="150">
                                <col width="150">
                                <col width="80">
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
                                            <span class="text-red font-bold">수익</span>
                                        @else
                                            <span class="text-blue font-bold">지출</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <span>{{ $ledger->_amount }}</span>
                                    </td>
                                    <td>{{ $ledger->purpose }}</td>
                                    <td class="text-center">{{ $ledger->user->name }} {{ $ledger->user->title }}</td>
                                    <td class="text-center">{{ $ledger->_created_at }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-default" href="{{ route('ledger.edit', [$ledger]) }}">수정</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $ledgers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

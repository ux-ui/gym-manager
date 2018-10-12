@title('지점관리')
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
                                <a href="{{ route('branch.create') }}" class="btn btn-primary">지점등록</a>
                            </div>
                        </div>
                        <table class="table">
                            <colgroup>
                                <col width="50">
                                <col>
                                <col width="150">
                                <col width="150">
                            </colgroup>
                            <thead>
                            <tr>
                                <th class="text-center">번호</th>
                                <th class="text-center">지점명</th>
                                <th class="text-center">생성일</th>
                                <th class="text-center">비고</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($branches as $branch)
                                <tr>
                                    <td class="text-center">{{ number($branches, $loop) }}</td>
                                    <td>{{ $branch->name }}</td>
                                    <td class="text-center">{{ $branch->_created_at }}</td>
                                    <td class="text-center">
                                        <div class="btn-group-sm">
                                            <a class="btn btn-default btn-sm text-center" href="{{ route('branch.edit', [$branch]) }}">수정</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $branches->links() }}
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

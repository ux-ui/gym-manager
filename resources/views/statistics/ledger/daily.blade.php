@title('일별 수입지출 지표')
@extends('layouts.app')

@section('content')

    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                        <div class="select_document">
                            <div class="view_style1">
                                <form action="{{ url()->current() }}" method="GET">
                                    <table>
                                        <colgroup>
                                            <col style="width:20%;">
                                            <col>
                                        </colgroup>
                                        <tbody>
                                        <tr>
                                            <th>지점선택</th>
                                            <td colspan="3" class="text-left">
                                                @foreach ($currentUser->branches as $branch)
                                                    @php
                                                        $checked = ! request()->has('branches') || in_array($branch->id, request()->get('branches'));
                                                    @endphp
                                                    <div class="d-inline-block">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="branches[]" value="{{ $branch->id }}"{{ $checked ? ' checked' : '' }}> {{ $branch->name }}
                                                            <i class="input-helper"></i>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>연도/월 선택</th>
                                            <td colspan="3" class="text-left">
                                                <div class="text-left">
                                                    <input type="text" name="year" value="{{ $year }}">
                                                    <input type="text" name="month" value="{{ $month }}">
                                                    <button class="btn btn-default d-inline-block" type="submit" style=" vertical-align: top; height: 31px;">검색</button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        @foreach ($ledgers->groupBy('day') as $day => $branches)
                            <div>
                                <h4>{{ $year }}년 {{ $month }}월 {{ $day }}일</h4>
                                <table class="table">
                                    <colgroup>
                                        <col>
                                        <col>
                                        <col style="width: 15%;">
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th>지점</th>
                                        <th>내역</th>
                                        <th>내역보기</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($branches as $ledger)
                                        @php
                                            $url = route('ledger.index', [
                                                'search' => sprintf("branch_id:%d;created_at:%s-%s-%s;", $ledger->branch->id, $year, $month, $day),
                                                'searchJoin' => 'AND',
                                            ]);
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $ledger->branch->name }}</td>
                                            <td class="text-right">
                                                <p>수입 : <span class="text-primary">{{ number_format($ledger->add) }}</span>원</p>
                                                <p>지출 : <span class="text-danger">{{ number_format($ledger->sub) }}</span>원</p>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-default" href="{{ $url }}">내역보기</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

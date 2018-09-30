@title('일별 수입지출 지표')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        <form action="{{ url()->current() }}" method="GET">
            <div class="flex mb-4">
                <div class="w-1/4 bg-grey text-center">
                    <b>지점선택</b>
                </div>
                <div class="w-3/4 bg-grey-light">
                    <div class="text-left">
                        @foreach ($currentUser->branches as $branch)
                            @php
                                $checked = ! request()->has('branches') || in_array($branch->id, request()->get('branches'));
                            @endphp
                            <label>
                                <input type="checkbox" name="branches[]" value="{{ $branch->id }}"{{ $checked ? ' checked' : '' }}> {{ $branch->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-1/4 bg-grey text-center">
                    <b>연도/월 선택</b>
                </div>
                <div class="w-3/4 bg-grey-light">
                    <div class="text-left">
                        <input type="text" name="year" value="{{ $year }}">
                        <input type="text" name="month" value="{{ $month }}">
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit">적용</button>
            </div>
        </form>
        @foreach ($ledgers->groupBy('day') as $day => $branches)
            <div>
                <h4>{{ $year }}년 {{ $month }}월 {{ $day }}일</h4>
                <table>
                    <tbody>
                    @foreach ($branches as $ledger)
                        @php
                        $url = route('ledger.index', [
                            'search' => sprintf("branch_id:%d;created_at:%s-%s-%s;", $ledger->branch->id, $year, $month, $day),
                            'searchJoin' => 'AND',
                        ]);
                        @endphp
                        <tr>
                            <th>{{ $ledger->branch->name }}</th>
                            <td>
                                <span>수입 : {{ number_format($ledger->add) }}원</span>
                                <span>지출 : {{ number_format($ledger->sub) }}원</span>
                                <a href="{{ $url }}">내역보기</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@endsection

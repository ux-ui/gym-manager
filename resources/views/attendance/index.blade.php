@title('출결관리')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        <form action="{{ route('attendance.index') }}" method="GET">
            <div class="flex mb-4">
                <div class="w-1/4 bg-grey text-center">
                    <b>지점선택</b>
                </div>
                <div class="w-3/4 bg-grey-light">
                    <div class="text-left">
                        @foreach ($currentUser->branches as $key => $value)
                            @php
                                $checked = $value->id == request()->get('branch') || (! request()->has('branch') && $key < 1);
                            @endphp
                            <label>
                                <input type="radio" name="branch" value="{{ $value->id }}"{{ $checked ? ' checked' : '' }}> {{ $value->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="flex mb-4">
                <div class="w-1/4 bg-grey text-center">
                    <b><label for="date">날짜선택</label></b>
                </div>
                <div class="w-3/4 bg-grey-light">
                    <div class="text-left">
                        <input type="date" id="date" name="date" value="{{ \Illuminate\Support\Carbon::now()->format('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit">적용</button>
            </div>
        </form>
        <div>
            <h4>{{ $date->format('Y년 m월 d일') }} {{ $branch->name }} 회원 출석부</h4>
            <table style="width: 100%;">
                <colgroup>
                    <col width="10%">
                    <col width="*">
                </colgroup>
                <tbody>
                @foreach ($members as $member)
                    <tr>
                        <th class="bg-grey border border-black">
                            {{ $member->name }}
                        </th>
                        <td class="text-center bg-grey-lighter border border-black" style="height: 100px;">
                            @if ($member->attendances->count() > 0)
                                <button class="toggleMemberAttendance" data-id="{{ $member->id }}">출석취소</button>
                            @else
                                <button class="toggleMemberAttendance" data-id="{{ $member->id }}">출석처리</button>
                            @endif
                            <div class="underProcessing hidden">
                                <span>자동으로 처리중입니다. 다음 출석체크를 계속해주세요.</span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function () {
        $('.toggleMemberAttendance').on('click', function (e) {
            var $target = $(e.target);
            var member_id = $target.data('id');
            var timeout = 1000;

            $.ajax({
                async: true,
                type: 'post',
                dataType: 'json',
                url: '{{ route('attendance.store') }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    member: member_id,
                    date: '{{ $date->format('Y-m-d') }}',
                },
                beforeSend: function () {
                    $target.hide();
                    $target.siblings('.underProcessing').show();
                },
                success: function(data) {
                    setTimeout(function () {
                        $target.show();
                        $target.siblings('.underProcessing').hide();
                        $target.text(data.flag === true ? '출석취소' : '출석처리');
                    }, timeout);
                }
            });
        });
    });
</script>
@endpush

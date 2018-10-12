@title('출결관리')
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
                                            <th>날짜선택</th>
                                            <td colspan="3" class="text-left">
                                                <div class="text-left">
                                                    <input type="date" id="date" name="date" value="{{ \Illuminate\Support\Carbon::now()->format('Y-m-d') }}">
                                                    <button class="btn btn-default d-inline-block" type="submit" style=" vertical-align: top; height: 31px;">검색</button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
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
                </div>
            </div>
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

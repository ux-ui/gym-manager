@title('통계분석')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        <form action="{{ route('statistics.index') }}" method="GET">
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
                    <b><label for="from">날짜선택</label></b>
                </div>
                <div class="w-3/4 bg-grey-light">
                    <div class="text-left">
                        <input type="date" id="from" name="from" value="{{ $from->format('Y-m-d') }}"> 부터
                        <input type="date" id="to" name="to" value="{{ $to->format('Y-m-d') }}"> 까지
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit">적용</button>
            </div>
        </form>
        {!! $memberRegistrationChart->container() !!}
    </div>
@endsection

@push('script')
    {!! $memberRegistrationChart->script() !!}
@endpush

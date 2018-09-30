@title('연도별 회원 출석률 지표')
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
            <div class="text-right">
                <button type="submit">적용</button>
            </div>
        </form>
        {!! $chart->container() !!}
    </div>
@endsection

@push('script')
    {!! $chart->script() !!}
@endpush

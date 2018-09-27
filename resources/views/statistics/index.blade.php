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
                        <label>
                            <input type="radio" name="branch" value="0"{{ request()->get('branch') == 0 || ! request()->has('branch') ? ' checked' : '' }}> 통합보기
                        </label>
                        @foreach ($currentUser->branches as $key => $value)
                            @php
                                $checked = $value->id == request()->get('branch');
                            @endphp
                            <label>
                                <input type="radio" name="branch" value="{{ $value->id }}"{{ $checked ? ' checked' : '' }}> {{ $value->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="text-right">
                <button type="submit">적용</button>
            </div>
        </form>
    </div>
@endsection

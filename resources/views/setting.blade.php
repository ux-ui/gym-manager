@title('기본설정')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        {!! form_start($form) !!}
        {!! form_rest($form) !!}
        <div class="text-right">
            <button type="submit">저장</button>
        </div>
        {!! form_end($form) !!}
    </div>
@endsection
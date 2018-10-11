@title('회원등록')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        {!! form_start($form) !!}
        {!! form_rest($form) !!}
        <div class="text-right">
            <button type="submit">등록</button>
            <a href="{{ route('member.index') }}">취소</a>
        </div>
        {!! form_end($form) !!}
    </div>
@endsection

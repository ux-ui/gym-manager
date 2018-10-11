@title('지점등록')
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                        {!! form_start($form) !!}
                        {!! form_rest($form) !!}
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">등록</button>
                            <a class="btn btn-danger" href="{{ route('branch.index') }}">취소</a>
                        </div>
                        {!! form_end($form) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

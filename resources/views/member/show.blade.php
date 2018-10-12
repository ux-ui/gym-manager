@title('회원정보')
@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                        <table class="table table-grid">
                            <colgroup>
                                <col width="15%">
                                <col>
                            </colgroup>
                            <tbody>
                            <tr>
                                <th>회원명</th>
                                <td>{{ $member->name }}</td>
                            </tr>
                            <tr>
                                <th>지점명</th>
                                <td>{{ $member->branch->name }}</td>
                            </tr>
                            <tr>
                                <th>주소</th>
                                <td>{{ $member->address }}</td>
                            </tr>
                            <tr>
                                <th>체중</th>
                                <td>{{ $member->weight }}</td>
                            </tr>
                            <tr>
                                <th>신장</th>
                                <td>{{ $member->height }}</td>
                            </tr>
                            <tr>
                            <tr>
                                <th>생년월일</th>
                                <td>{{ $member->bdate }}</td>
                            </tr>
                            <tr>
                                <th>등록일</th>
                                <td>{{ $member->regdate }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="btn_write text-center">
                            <a class="btn btn-primary" href="{{ route('member.edit', [$member]) }}">수정</a>
                            <a class="btn btn-default" href="{{ route('member.index') }}">목록</a>
                            <form class="d-inline-block" method="POST" action="{{ route('member.destroy', [$member]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">삭제</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

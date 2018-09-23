@title('내역정보')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="border-b mb-2 pb-2">{{ $title }}</h3>
        <table>
            <tbody>
            <tr>
                <th>구분</th>
                <td>
                    @if ($ledger->type === '+')
                        <span class="text-red font-bold">{{ $ledger->_type }}</span>
                    @else
                        <span class="text-blue font-bold">{{ $ledger->_type }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>내용</th>
                <td>
                    <span>{{ $ledger->purpose }}</span>
                </td>
            </tr>
            <tr>
                <th>금액</th>
                <td>
                    <span>{{ $ledger->_amount }}</span>
                </td>
            </tr>
            <tr>
                <th>생성자</th>
                <td>
                    <span>{{ $ledger->user->name }} {{ $ledger->user->title }}</span>
                </td>
            </tr>
            <tr>
                <th>생성일</th>
                <td>{{ $ledger->_created_at }}</td>
            </tr>
            </tbody>
        </table>
        <div class="text-right">
            <a href="{{ route('ledger.index') }}">목록</a>
            <a href="{{ route('ledger.edit', [$ledger]) }}">수정</a>
            <form method="POST" action="{{ route('ledger.destroy', [$ledger]) }}">
                @csrf
                @method('DELETE')
                <button type="submit">삭제</button>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="bg-grey-lighter flex justify-center py-10 absolute" style="width: 100%; height: 100%;">
        <div class="w-full max-w-xs">
            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" method="POST" action="{{ route('login') }}">
                @csrf
                <h1 class="mb-5 text-blue-darker">{{ Setting::get('gym_name') }}</h1>
                <div class="mb-2">
                    <label class="block text-grey-darker text-sm font-bold mb-2" for="username">아이디</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline{{ $errors->has('username') ? ' border-red' : '' }}" id="username" name="username" type="text" value="{{ old('username') }}">
                    @if ($errors->has('username'))
                        <p class="text-red text-xs italic">{{ $errors->first('username') }}</p>
                    @endif
                </div>
                <div class="mb-2">
                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">패스워드</label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker mb-3 leading-tight focus:outline-none focus:shadow-outline{{ $errors->has('password') ? ' border-red' : '' }}" id="password" name="password" type="password">
                    @if ($errors->has('password'))
                        <p class="text-red text-xs italic">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="block text-black">
                        <input class="mr-2 leading-tight" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="text-sm">로그인 상태를 유지합니다.</span>
                    </label>
                </div>
                <div class="flex items-center justify-between">
                    <button class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">로그인</button>
                </div>
            </form>
            <p class="text-center text-grey text-xs">
                ©2018 {{ Setting::get('gym_name') }}. All rights reserved.
            </p>
        </div>
    </div>
@endsection

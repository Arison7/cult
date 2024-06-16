@extends('layouts.main')
@section('body')
    <div class="flex justify-center">

        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-[66vw] h-full max-w-[600px]"
            action="{{ route('auth.login') }}" method="POST" id="loginForm">
            @csrf

            <h2 class="text-2xl font-bold mb-4 text-center ">Welcome back cultist</h2>
			@if(session('status'))
				<div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center">
					{{session('status')}}
				</div>
			@endif
            @if(session('error'))
                <div class="bg-red-500 p-4 rounded-lg mb-6 text-white text-center">
                    {{ session('error') }}
                </div>
            @endif
            <div class="mb-2 pb-2">
                <labelsmtp="block text-gray-700 text-sm font-bold mb-2" for="email">Email:*</labelsmtp=>
                <div class="flex flex-row w-full">
                    <input id="inEmail"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror" 
                        type="email" name="email" placeholder="Your@email.com">
                </div>
                <div class="text-red-500  text-sm" id="EmailErr">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-2 pb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password:*</label>
                <div class="flex flex-row w-full">
                    <input id="inPass"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror"
                        type="password" name="password" placeholder="Your password here">
                </div>
                <div class="text-red-500 text-sm" id="PassErr">
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>

            </div>
			<div class="mb-4 flex flex-col">
				<div class="flex intems-center">
					<input type="checkbox" name="remember" id="remember" class="mr-2">
					<label for="remember">Remember me</label>
				</div>
                <a href="{{ route('password.request') }}">Forgot Your Password?</a><br>
			</div>
            <div class="text-center">
                <button class="bg-black hover:bg-red-600 text-white font-bold py-2 px-5 rounded focus:outline-none focus:shadow-outline"
                    type="submit" >Log in</button>
            </div>

        <div class="text-center mt-4">
            <p class="text-gray-600">We recommend using a password manager to securely store and manage your passwords.</p>
        </div>
        </form>
    </div>
@endsection

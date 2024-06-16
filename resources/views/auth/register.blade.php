@extends('layouts.main')

@section('head')
  @vite('resources/js/register.js')
@endsection

@section('body')
    <div class="flex justify-center">
        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-[66vw] h-full max-w-[600px]"
            action="{{ route('auth.register') }}" method="POST" id="registerForm">
            @csrf
            <h2 class="text-2xl font-bold mb-4 text-center ">Do you want to join a</h2>
            <h2 class="text-2xl font-bold mb-4 text-center text-red-600">CULT?</h2>
            <div class="mb-2 pb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="cult-name">Your cultist name (It can be
                    changed later):* </label>
                <div class="flex flex-row w-full">
                    <input id="inName"
                        class="shadow appearance-none border grid-span-2 rounded py-2 px-3 w-4/5  text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="text" name="name" placeholder="Cultity123">
                    <div class="flex align-middle justify-center w-1/5 h-full">
                        <img id="inNameImg" class="align-middle cursor-pointer max-h-8 max-w-8" />
                    </div>
                </div>
                <div class="text-red-500 text-sm" id="NameErr">
                    @error('name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-2 pb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email:*</label>
                <div class="flex flex-row w-full">
                    <input id="inEmail"
                        class="shadow appearance-none border rounded w-4/5 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="email" name="email" placeholder="Your@email.com">
                    <div class="flex align-middle justify-center w-1/5 h-full">
                        <img id="inEmailImg" class="align-middle cursor-pointer max-h-8 max-w-8" />
                    </div>
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
                        class="shadow appearance-none border rounded w-4/5 py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline"
                        type="password" name="password" placeholder="Your password here">
                    <div class="flex align-middle justify-center w-1/5 h-full">
                        <img id="inPassImg" class="align-middle cursor-pointer max-h-8 max-w-8" />
                    </div>
                </div>
                <div class="text-red-500 text-sm" id="PassErr">
                    @error('password')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="mb-2 pb-2">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="repeat-password">Repeat
                    password:*</label>
                <div class="flex flex-row w-full">
                    <input id="inPassRep"
                        class="shadow appearance-none border rounded w-4/5 py-2 px-3 text-gray-700  leading-tight focus:outline-none focus:shadow-outline"
                        type="password" name="passwordConfirmation" placeholder="Repeat your password here">
                    <div class="flex align-middle justify-center w-1/5 h-full">
                        <img id="inPassRepImg" class="align-middle cursor-pointer max-h-8 max-w-8" />
                    </div>
                </div>
                <div class="text-red-500 text-sm" id="PassRepErr">
                    @error('passwordConfirmation')
                        {{ $message }}
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button class="bg-black text-white font-bold py-2 px-5 rounded focus:outline-none focus:shadow-outline"
                    type="submit" id="registerSubmit">JOIN US</button>
            </div>
        <div class="text-center mt-4">
            <p class="text-gray-600">We recommend using a password manager to securely store and manage your passwords.</p>
        </div>
        </form>
    </div>
@endsection

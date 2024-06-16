@extends('layouts.main')

@section('body')
    <div class="text-white font-sans leading-normal tracking-normal">
        <div class="mx-auto p-5 flex flex-col justify-center">
            <h1 class="text-4xl font-bold mb-5 p-8">What mischief things do you want to do?</h1>
            <hr class="border-red-600 border-2 mb-10">
            <div class="flex mb-5 self-center flex-col">
                <form action="{{ route('errors.notFound') }}" method="GET" class="self-center mb-4">
                    @csrf
                    <input type="submit" value="Look for something that isn't there"
                        class="bg-black hover:bg-red-600 text-white font-bold py-2 px-4 rounded self-center cursor-pointer"></input>
                </form>
                <form action="{{ route('errors.internalServerError') }}" method="GET" class="self-center ">
                    @csrf
                    <input type="submit" value="Mess with things you shouldn't mess with"
                        class="bg-black hover:bg-red-600 text-white font-bold py-2 px-4 rounded self-center cursor-pointer"></input>
                </form>
            </div>
            <hr class="border-red-600 border-2 w-1/6 self-center" >
            <form action="{{ route('auth.logout') }}" method="POST" class="self-center">
                @csrf
                <input type="submit" value="Logout"
                    class="bg-black hover:bg-red-600 text-white font-bold py-2 px-4 rounded mt-5 self-center cursor-pointer"></input>
            </form>
        </div>
    </div>
@endsection

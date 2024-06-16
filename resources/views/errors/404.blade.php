@extends('layouts.main')


@section('body')
	<div class="text-center font-bold text-white flex flex-col">
        <div class=" flex flex-row justify-center" style="font-size: 8rem">
            <div class="text-red-600" >4</div><div>0</div><div class="text-red-600 text-9xl" >4</div>
        </div>
        <p class="text-4xl text-white mt-4 mb-6">Page not found</p>
        <a href="{{ url()->previous() }}" class="mt-6 inline-block hover:bg-red-600 bg-black text-white px-6 py-2 rounded">Go back</a>
    </div>
@endsection
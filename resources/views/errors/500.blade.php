@extends('layouts.main')


@section('body')
<div class="text-center font-bold text-white flex flex-col">
	<div class=" flex flex-row justify-center" style="font-size: 8rem">
		<div class="text-red-600" >5</div><div>00</div>
	</div>
	<p class="text-4xl text-white mt-4 mb-6">internal Server Error</p>
	<a href="{{ url()->previous() }}" class="mt-6 inline-block hover:bg-red-600 bg-black text-white px-6 py-2 rounded">Go back</a>

@endsection
@extends('admin.layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">


<h1 class="text-3xl font-bold text-gray-800 mb-6">
    Programs Dashboard
</h1>


@if(session('success'))

<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-5">
    {{ session('success') }}
</div>

@endif

@if ($errors->any())
<div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">
    Please check the programs page fields and try again.
</div>
@endif

<div class="bg-white shadow rounded-xl p-6 mb-8">
    <div class="flex items-center justify-between gap-4 mb-4">
        <h2 class="text-xl font-semibold">Programs Page Hero</h2>
        <a href="{{ route('programs') }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded">View Page</a>
    </div>

    <form action="{{ route('admin.content.program.update') }}" method="POST" class="space-y-4">
        @csrf

        <input
            type="text"
            name="hero_label"
            placeholder="Hero label"
            value="{{ old('hero_label', $page->hero_label) }}"
            class="w-full border rounded-lg px-4 py-3">

        <input
            type="text"
            name="hero_title"
            placeholder="Hero title"
            value="{{ old('hero_title', $page->hero_title) }}"
            class="w-full border rounded-lg px-4 py-3"
            required>

        <textarea
            name="hero_description"
            placeholder="Hero description"
            rows="4"
            class="w-full border rounded-lg px-4 py-3">{{ old('hero_description', $page->hero_description) }}</textarea>

        <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            Update Programs Page
        </button>
    </form>
</div>



<!-- CREATE PROGRAM -->

<div class="bg-white shadow rounded-xl p-6 mb-8">

<h2 class="text-xl font-semibold mb-4">
    Add New Program
</h2>


<form action="{{ route('admin.content.program.store') }}"
      method="POST"
      enctype="multipart/form-data"
      class="space-y-4">


@csrf


<input
type="text"
name="title"
placeholder="Program title"
class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500"
required>


<textarea
name="description"
placeholder="Program description"
rows="4"
class="w-full border rounded-lg px-4 py-3"
required></textarea>


<input
type="text"
name="icon"
placeholder="FontAwesome icon"
class="w-full border rounded-lg px-4 py-3">


<input
type="file"
name="image"
class="w-full border rounded-lg px-4 py-3">



<button
class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">

Create Program

</button>


</form>

</div>




<!-- PROGRAM LIST -->


<div class="grid md:grid-cols-3 gap-6">


@foreach($programs as $program)


<div class="bg-white rounded-xl shadow overflow-hidden">


@if($program->image)

<img 
src="{{ asset('storage/'.$program->image) }}"
class="h-48 w-full object-cover">

@endif



<div class="p-5">


<h3 class="text-xl font-bold text-gray-800">
{{ $program->title }}
</h3>



<p class="text-gray-600 mt-2">
{{ $program->description }}
</p>



@if($program->icon)

<span class="inline-block mt-3 text-blue-600">
<i class="{{ $program->icon }}"></i>
{{ $program->icon }}
</span>

@endif



<div class="mt-5 flex gap-3">


</div>


</div>

</div>


@endforeach


</div>


</div>

@endsection

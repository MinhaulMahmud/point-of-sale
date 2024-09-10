@extends('layout.app')
@section('title')
	Profile
@endsection
@section('content')
    <div class="wrapper">
    	<div class="min-h-screen bg-gray-100">
            @include('layout.sidebar')

        </div>
		<div class="main">
			@include('layout.navbar')

			<main class="content">
				@include('components.dashboard.profile')
			</main>

			@include('layout.footer')
		</div>
	</div>
@endSection
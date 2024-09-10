@extends('layout.app')
@section('title')
	Dashboard
@endsection
@section('content')
    <div class="wrapper">
    	<div class="min-h-screen bg-gray-100">
            @include('layout.sidebar')

        </div>
		<div class="main">
			@include('layout.navbar')

			<main class="content">
				<div class="container-fluid p-0">

                    @include('components.dashboard.summary2')

				</div>
			</main>

			
		</div>
	</div>
@endSection
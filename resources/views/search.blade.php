@php
	$s = get_query_var('s');
	$by_name = get_name_by_title($s);
@endphp
@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (! have_posts())
		<div class="container px-8">
    	<x-alert type="warning" class="p-4 mt-8 rounded-lg">
      	{!! __('Sorry, no results were found in our database.', 'sage') !!}
    	</x-alert>
		</div>
  @endif

	<ul class="name_cards">
  	@while(have_posts()) @php(the_post())
    	@include('partials.content-search')
  	@endwhile
	</ul>
	@if (App\have_name_data())
		<div id="stats">
			@if (!$by_name)
				<h2>Name Trends for {{ ucwords($s)}} </h2>
				@include ('partials.graph')
			@endif
		</div>
	@endif
@endsection



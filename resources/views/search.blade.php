@php
	$s = get_query_var('s');
	$by_name = get_name_by_title($s);
@endphp
@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (! have_posts())
		<div class="container">
    	<x-alert type="warning" class="p-4 mt-8 rounded-lg">
      	{!! __('Sorry, no results were found in our database.', 'sage') !!}
    	</x-alert>
		</div>
  @endif

  @while(have_posts()) @php(the_post())
    @include('partials.content-search')
  @endwhile

  {!! get_the_posts_navigation() !!}
@endsection

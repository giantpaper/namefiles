@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @if (! have_posts())
    <x-alert type="warning">
      {!! __('Sorry, no results were found.', 'sage') !!}
    </x-alert>

    {!! get_search_form(false) !!}
  @endif

	<ul class="grid lg:grid-cols-2 max-w-2xl mx-auto">
  @while(have_posts()) @php(the_post())
    @include('partials.content-' . get_post_type())
  @endwhile
	</ul>

  {!! get_the_posts_navigation() !!}
@endsection

@section('sidebar')
  @include('sections.sidebar')
@endsection

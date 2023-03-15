<li @php(post_class('p-8'))>
	<a href="{{ get_permalink() }}">
	<p class="text-sm">
		@include('partials.entry-meta')
	</p>
  	<h2 class="entry-title h3 text-center">
      {!! $title !!}
  	</h2>
	</a>
</li>

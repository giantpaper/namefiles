@php
$subtitle = null;
if (is_tax()) {
	preg_match_all("#^([\w ]+): (.+)#", $title, $m);
	$subtitle = $m[1][0];
	$title = strip_tags($m[2][0]);
}
@endphp

<div class="page-header">
	<div class="bg">
		@if (is_home())
			{!! get_the_post_thumbnail(get_page_by_path('news'), 'full') !!}
		@else
			{!! the_post_thumbnail() !!}
		@endif
	</div>
	<hgroup>
		@if ($subtitle != null)
			<p class="subtitle h3 text-center">{!! $subtitle !!}</p>
		@endif
  	<h1>{!! $title !!}</h1>
	</hgroup>
</div>

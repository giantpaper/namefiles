@php

$terms_nametypes = get_the_terms($post->ID, 'nametype');
$terms_related = get_the_terms($post->ID, 'grouping');
$terms_altspellings = get_the_terms($post->ID, 'altspelling');
$terms_origin = get_the_terms($post->ID, 'origin');
$terms_gender = get_the_terms($post->ID, 'gender');

$terms_nametag = get_the_terms($post->ID, 'nametag');

$genderlist = [];
$nametypelist = [];
$originlist = [];
$nametaglist = [];

foreach ( $terms_nametypes as $term ) {
	$nametypelist[] = $term->name;
}
if ( $terms_origin !== false ) {
	foreach ( $terms_origin as $term ) {
		$originlist[] = $term->name;
	}
}
if ( $terms_nametag !== false ) {
	foreach ( $terms_nametag as $term ) {
		$nametaglist[] = [
			'id' => $term->term_id,
			'display' => str_replace('-', '', $term->slug)
		];
	}
}
if ( $terms_gender !== false ) {
	foreach ( $terms_gender as $term ) {
		$genderlist[] = $term->name;
	}
}

$nametypephrasing = null;
if ( count($nametypelist) > 1 ) {
	$nametypephrasing = 'both ';
}
if ( count($nametypelist) > 0 ) {
	$nametypephrasing .= implode(' and ', $nametypelist);
}
else {
	$nametypephrasing = null;
}

$genderphrasing = text_list($genderlist);

$nametypephrasing = str_replace('Given Name', $genderphrasing . ' Given Name', $nametypephrasing);

$originphrasing = count($originlist) > 0 ? ' of ' .text_list($originlist) . ' origin' : null;

$have_related_names = tnf_have_terms('grouping', $terms_related);
$have_altspellings = tnf_have_terms('altspelling', $terms_altspellings);

$related_names_intro = '<strong>' .$post->post_title.'</strong> shares its roots with these names:';

$field_altspellings = array_map('trim', explode(',', get_field('alt_spellings')));

if ( $terms_related && $terms_altspellings !== false && count($terms_related) > 1 )
	$related_names_intro = $post->post_title.' shares its roots with other names—grouped by meaning:';
@endphp
<article @php(post_class())>
	<header>
		<h1 class="name-title">
			{!! $title !!}
		</h1>
		<p class="name-pronunciation">{!! the_field('pronunciation') !!}</p>

		@if ($nametypephrasing != null)
			<p class="name-briefing">... is a {{ $nametypephrasing.$originphrasing }}</p>
		@endif
	</header>

	@if(get_field('meaning'))
		<section class="name-meaning">
			<h4>Meaning</h4>
			<p>@php(the_field('meaning'))</p>
		</section>
	@endif
	@if (get_the_content())
		<div class="name-content">
			@php(the_content())
		</div>
	@endif

	@if (count($nametaglist) > 0)
		<ul class="nametags mx-auto max-w-lg mt-16">
		@foreach ($nametaglist as $tag)
			<li class="inline"><a href="{{ get_term_link($tag['id']) }}">#{{ $tag['display'] }}</a></li>
		@endforeach
		</ul>
	@endif
	@if ($terms_altspellings !== false && count($terms_altspellings) > 0 && !in_array(false, $have_altspellings))
	<section id="altspellings"><div class="container lazyload" data-animate="fadeInUp">
		<h2>Alternate Spellings:</h2>

		<ul>
		<?php
		foreach ($terms_altspellings as $tax) :
			//	get by 'meaning' child terms
			$altspellings__meaning = get_posts([
				'posts_per_page' => -1,
				'post_type' => 'tnf_name',
				'exclude' => $post->ID,
				'child_of' => 29, // Meaning term
				'tax_query' => [
					[
						'taxonomy' => 'altspelling',
						'field' => 'term_id',
						'terms' => $tax->term_id,
					],
				]
			]);
			if ( count($altspellings__meaning) > 0 ) {
				echo '<div class="d-flex">';
				if ( count($terms_altspellings) > 1 ) {
					$name = $tax->description ?: $tax->name;
					echo '<h3>' . $name . '</h3>';
				}
				echo '</div>';
				echo '<ul class="name_cards">';
				foreach ($altspellings__meaning as $name) {
					$altspellings_gender = get_the_terms($name->ID, 'gender')[0]->term_id;
					$altspellings_meaning = get_field('meaning', $name->ID);
					$altspellings_pronunciation = get_field('pronunciation', $name->ID);
					echo '<li><a href="' .get_permalink($name->ID). '"
						data-gender="' .$altspellings_gender. '"
						data-meaning="' .$altspellings_meaning. '"
						data-pronunciation="' .$altspellings_pronunciation. '"
						class="name_card">' .$name->post_title. '</a></li>';
				}
				echo '</ul>';
			}
		endforeach; ?>
		</ul>
	</div></section>
	@endif

	@if (!empty($terms_related) && !in_array(false, $have_related_names))
	<section id="related_names"><div class="container lazyload" data-animate="fadeInUp">
		<h2>Related Names:</h2>

		<p>{!! $related_names_intro !!}</p>
		<ul>
		<?php foreach ($terms_related as $tax) :
			//	get by 'meaning' child terms
			$related_names__meaning = get_posts([
				'posts_per_page' => -1,
				'post_type' => 'tnf_name',
				'exclude' => $post->ID,
				'child_of' => 29, // Meaning term
				'tax_query' => [
					[
						'taxonomy' => 'grouping',
						'field' => 'term_id',
						'terms' => $tax->term_id,
					],
				]
			]);
			if ( count($related_names__meaning) > 0 ) {
				echo '<div class="d-flex">';
				if ( count($terms_related) > 1 ) {
					$name = $tax->description ?: $tax->name;
					echo '<h3>' . $name . '</h3>';
				}
				echo '</div>';
				echo '<ul class="name_cards">';
				foreach ($related_names__meaning as $name) {
					$genders = get_the_terms($name->ID, 'gender');
					$related_genders = get_the_terms($name->ID, 'gender');
					foreach($related_genders as $i => $term) {
						$related_genders[$i] = $term->term_id;
					}
					$related_gender = implode(',', $related_genders);
					$related_meaning = get_field('meaning', $name->ID);
					$related_pronunciation = get_field('pronunciation', $name->ID);
					echo '<li><a href="' .get_permalink($name->ID). '"
						data-gender="' .$related_gender. '"
						data-meaning="' .$related_meaning. '"
						data-pronunciation="' .$related_pronunciation. '"
						data-edit="' .get_edit_post_link($name->ID). '"
						class="name_card">' .$name->post_title. '</a></li>';
				}
				echo '</ul>';
			}
		endforeach; ?>
		</ul>
	</div></section>
	@endif
	@if (SHOW_GRAPH)
	<section id="stats" class="loading">
		<h2 class="container lazyload text-center" data-animate="fadeInUp">Trending</h2>
		@include('partials.graph')
	</section>
	@endif

	@if (have_rows('sources'))
	<footer id="sources"><div class="container lazyload" data-animate="fadeInUp">
		<div class="row">
			<div class="col-lg-2"></div>
			<div class="col-lg">
				<h2>Sources:</h2>
				<ol>
					<?php $i = 1; while (have_rows('sources')) : the_row(); ?>
					<li id="sourcelink_{{ $i }}"><a href="{!! get_sub_field('url') !!}" target="_blank" rel="noopener">{!! get_sub_field('title') ?: get_sub_field('url') !!}</a>
						@if ( get_sub_field('comments') )
							<br>{!! get_sub_field('comments') !!}
						@endif
					</li>
					<?php $i++; endwhile; ?>
				</ol>
			</div>
			<div class="col-lg-2"></div>
		</div>
	</div></footer>
	@endif
</article>

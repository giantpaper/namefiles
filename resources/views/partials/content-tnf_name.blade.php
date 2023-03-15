@php

$terms_nametypes = get_the_terms($post->ID, 'nametype');
$terms_related = get_the_terms($post->ID, 'grouping');
$terms_altspellings = get_the_terms($post->ID, 'altspelling');
$terms_origin = get_the_terms($post->ID, 'origin');
$terms_gender = get_the_terms($post->ID, 'gender');

$genderlist = [];
$nametypelist = [];
$originlist = [];

foreach ( $terms_nametypes as $term ) {
	$nametypelist[] = $term->term_id;
}
if ( $terms_origin !== false ) {
	foreach ( $terms_origin as $term ) {
		$originlist[] = $term->term_id;
	}
}
if ( $terms_gender !== false ) {
	foreach ( $terms_gender as $term ) {
		$genderlist[] = $term->term_id;
	}
}
ob_start();
edit_post_link();
$edit = is_user_logged_in() ? preg_replace("#^.+href=\"([^\"]+)\".+$#", "\\1", ob_get_contents()) : null;
ob_end_clean();


@endphp
<a href="{{ get_permalink() }}"
	data-gender="{{ implode(',', $genderlist) }}"
	data-meaning="{{ get_field('meaning') }}"
	data-pronunciation="{{ get_field('pronunciation') }}"
	data-edit="{{ $edit }}"
	class="name_card">{{ the_title() }}</a>


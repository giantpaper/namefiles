<a href="{{ get_permalink() }}" class="name_card"
	data-gender="{{ get_the_terms($post->ID, 'gender')[0]->term_id }}"
	data-meaning="{{ get_field('meaning') }}"
	data-pronunciation="{{ get_field('pronunciation') }}"
	data-edit="{{ get_edit_post_link($post->ID) }}"
	>
	{!! $title !!}
</a>

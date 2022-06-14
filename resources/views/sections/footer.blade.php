@php
	$list = ['origin', 'gender', 'nametype'];
	$use_radio = ['nametype'];

	$newest = new WP_Query([
		'posts_per_page' => 1,
		'post_type' => 'name',
		'orderby' => 'modified',
		'order' => 'DESC',
	]);
	$names_modified = strtotime('today');
	if ($newest->have_posts()) : while ($newest->have_posts()) : $newest->the_post();
		$names_modified = get_the_modified_date('Y-m-d__H-i-s');
	endwhile; endif; wp_reset_postdata();
@endphp

<div id="filter_menu_wrapper">
	<form id="filter_menu" class="hide">
		<div class="by_name" style="display: none">
			<label for="s">Search</label>
			<input type="search" id="s" name="s" value="" />
			<button><i class="fa-solid fa-magnifying-glass"></i></button>
		</div>
		<div class="inner">
		@foreach ($list as $name)
			@php
				$terms = get_terms($name);
				$tax = get_taxonomy($name);
			@endphp
			<fieldset id="{!! $tax->name !!}">
				<legend>{{ $tax->label }}:</legend>
				<ul>
					@foreach ($terms as $term)
					<li>
						<label class="filter_option" for="{{ $name }}_{{ $term->term_id }}">
							@if ( in_array($name, $use_radio) )
								<span class="field radio">
									<i class="far fa-circle unchecked"></i>
									<i class="fas fa-check-circle checked"></i>
								</span>
								<input type="radio" name="{{ $name }}[]" id="{{ $name }}_{{ $term->term_id }}" value="{{ $term->term_id }}">
							@else
								<span class="field checkbox">
									<i class="far fa-square unchecked"></i>
									<i class="fas fa-check-square checked"></i>
								</span>
								<input type="checkbox" name="{{ $name }}[]" id="{{ $name }}_{{ $term->term_id }}" value="{{ $term->term_id }}">
							@endif
						{{ $term->name }}
					</label>
				</li>
				@endforeach
				</ul>
			</fieldset>
		@endforeach
		</div>
		<div class="submit"><button type="submit">Filter</button></div>
		<input type="hidden" name="order" value="desc" />
		<input type="hidden" name="modified" value="false" />
		<input type="hidden" name="per_page" value="20" />
	</form>
	<button id="filter_btn">
		<i>Filter</i>
	</button>
</div>

<footer class="content-info">

	<p id="copyright">© {{ date('Y') }} The Name Files</p>
</footer>

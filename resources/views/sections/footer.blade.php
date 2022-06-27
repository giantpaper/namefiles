@php
	$list = ['origin', 'firstinitial', 'gender', 'nametype', ];
	// $use_radio = ['nametype'];
	$use_radio = [];

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


@if (SHOW_GRAPH && have_rows('graph_faqs', 'option'))
	<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
	id="statsnotes-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog relative w-auto pointer-events-none">
			<div
				class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
				<div
					class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
					<h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">Graph FAQs</h5>
					<button type="button"
						class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
						data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body relative p-4">
					@php
						$accordion = new Accordion('statsnotes');
						$accordion->classes(['note']);
						while (have_rows('graph_faqs', 'option')) { the_row();
							$accordion->item(get_sub_field('question'), function() {
								the_sub_field('answer');
							});
						}
						$accordion->end();
					@endphp
				</div>
			</div>
		</div>
	</div>
@endif

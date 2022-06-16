<?php

if ( !is_admin() ) {

	function embedded_css($identifier=null, $suffix=null) {
		global $post;
		$highlight = [];

		if ( !empty($identifier) ) {
			$highlight = get_field('header_highlight', $identifier);
		}

		$highlight = \shortcode_atts([
			'color' => '000000',
			'opacity_outer' => '0',
			'opacity_inner' => '50',
		], $highlight);

		$highlight['color'] = str_replace('#', '', $highlight['color']);
		for($i=0;$i<3;$i++) {
			$hex[$i] = substr($highlight['color'], $i > 0 ? ($i - 1) + 2 : $i, 2);
		}

		if ( !empty($suffix) ) {
			$suffix = '-' .$suffix;
		}
		?>
		<style type="text/css">
		:root {
			--header-highlight-color<?= $suffix ?>: <?= implode(',', array_map('hexdec', $hex)) ?>;
			--header-highlight-opacity_outer<?= $suffix ?>: <?= $highlight['opacity_outer'] * 0.01 ?>;
			--header-highlight-opacity_inner<?= $suffix ?>: <?= $highlight['opacity_inner'] * 0.01 ?>;
		}
		</style>
		<?php
	}


	function text_list($array=[]) {
		$last = array_pop($array);

		return count($array) > 0 ? implode(', ', $array) . ' and '. $last : $last;
	}

	function get_list ($terms=[]) {
		if (!is_array($terms))
			return null;

		$list = array_map(function($term){
			global $tax;
			return get_term($term, $tax)->name;
		}, $terms);

		return implode(', ', $list);
	}

	function gender_icon($id) {

				if ( !is_array(get_the_terms($id, 'gender')) ) {
						return [
								'html' => null,
								'name' => null,
						];
				}
		$g = get_list(get_the_terms($id, 'gender'));

		switch ($g) {
			case 'Female':
				$g_fa = 'fa-venus';
				break;
			case 'Male':
				$g_fa = 'fa-mars';
				break;
			case 'Male, Female':
			case 'Female, Male':
				$g_fa = 'fa-venus-mars';
				break;
			case 'Neutral':
			default:
				$g_fa = 'fa-neuter';
				break;
		}
		$info = [
			'alt' => $g,
			'fa' => $g_fa,
		];
		return [
			'html' => sprintf('<i class="fa-light %s gender-icon" aria-label="%s" title="%2$s"></i>', $info['fa'], $info['alt']),
			'name' => $g,
		];
	}
	function add_gender_icon ($name) {
		$icon = gender_icon($name->ID);
		$title = $name->post_title;
		$title .= ' ' . $icon['html'];
		return '<span class="name-title-inner ' .str_replace(', ', '-', strtolower($icon['name'])). '">' .$title. '</span>';
	}

	class Accordion {
		private $i = 0;
		private $id = null;
		private $items = [];
		private $classes = [];
		function __construct($id) {
			$this->id = $id;
		}
		function classes ($classes=[]) {
			if (!empty($classes))
				$this->classes = implode(' ', $classes);
		}
		function item ($title, $func) {

			$id = $this->id. '_' .$this->i;
			$id_title = $id . '__title';
			$id_body = $id . '__body';
			$active = $this->i == 0 ? 'show' : null;

			$contents = '<div class="accordion-item">';

			$contents .= '<h2 class="h0 accordion-header" id="' . $id_title . '">
				<button class="text-primary accordion-button btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#' . $id_body . '" aria-expanded="true" aria-controls="' . $id_title . '">' .$title. '</button>
			</h2>';

			$contents .= '<div id="' . $id_body . '" class="accordion-collapse collapse ' .$active. '" aria-labelledby="' . $id_title . '" data-bs-parent="#' .$this->id. '">
			<div class="accordion-body">';
			$contents .= $this->get_output($func);

			$contents .= '</div>
			</div>';

			$contents .= '</div>';

			$this->i++;

			$this->items[] = $contents;

			return $contents;
		}
		private function get_output ($func) {
			ob_start();

			$func($this);

			$contents = ob_get_contents();
			ob_end_clean();
			return $contents;
		}

		function end () {
			$classes = !empty($this->classes) ? ' ' .$this->classes : null;
			echo '<div class="accordion' .$classes. '" id="' .$this->id. '">';

			foreach ($this->items as $item) {
				echo $item;
			}

			echo '</div>';
		}

		function __destruct() {
		}
	}

	function namelink ($name) {
		$post = $name;
		return sprintf('<a href="%s">%s</a>', get_permalink($name->ID), add_gender_icon($name));
	}

	function get_name_by_title ($name) {
		return get_page_by_title($name, OBJECT, 'name');
	}

	function tnf_have_terms($tax, $terms) {
		if ($terms === false)
			return false;

		for ($i=0; $i < count($terms); $i++) {
			$param_a[] = $tax;
		}

		return array_map(function($term, $tax) {
			global $post;
			$p = get_posts([
				'posts_per_page' => -1,
				'post_type' => 'name',
				'exclude' => $post->ID,
				'tax_query' => [
					[
						'taxonomy' => $tax,
						'field' => 'term_id',
						'terms' => $term->term_id,
					]
				]
			]);
			return count( $p ) > 0;
		}, $terms, $param_a);
	}

	add_filter('the_title', function($title){
		// Don't do this thru API
		if ( !(defined( 'REST_REQUEST' ) && REST_REQUEST) ) {
			$name = get_name_by_title($title);
			if ( $name != null && $name->post_type == 'name' ) {
				$icon = gender_icon($name->ID);
				$title = $icon['html']. ' ' . $title;
				$title = '<span class="name-title-inner ' .str_replace(', ', '-', strtolower($icon['name'])). '">' .$title. '</span>';
			}
		}

		return $title;
	});

	function source_links($content){
		$content = preg_replace_callback("#\[\[([^\]]+)\]\]#", function($r){
			$linked = get_name_by_title($r[1]);
			$name = $r[1];

			if ( $linked != null ) {
				$permalink = get_permalink($linked->ID);
				$name = sprintf('<a href="%s">%s</a>', $permalink, get_the_title($linked->ID));
			}
			return $name;
		}, $content);
		$content = preg_replace("#\[\^([0-9]+)\]#", is_singular('name') ? '<sup class="ref"><a href="#sourcelink_$1">$1</a></sup>' : null, $content);
		return $content;
	};
	add_filter('acf/load_value/type=text', 'source_links', 20);
	add_filter('the_content', 'source_links', 20);

}

?>

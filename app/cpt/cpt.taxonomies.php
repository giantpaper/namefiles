<?php
function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Origins.
	 */

	$args = [
		"label" => __( "Origins", "sage" ),
		"labels" => [
			"name" => __( "Origins", "sage" ),
			"singular_name" => __( "Origin", "sage" ),
			"menu_name" => __( "Origins", "sage" ),
			"all_items" => __( "All Origins", "sage" ),
			"edit_item" => __( "Edit Origin", "sage" ),
			"view_item" => __( "View Origin", "sage" ),
			"update_item" => __( "Update Origin name", "sage" ),
			"add_new_item" => __( "Add new Origin", "sage" ),
			"new_item_name" => __( "New Origin name", "sage" ),
			"parent_item" => __( "Parent Origin", "sage" ),
			"parent_item_colon" => __( "Parent Origin:", "sage" ),
			"search_items" => __( "Search Origins", "sage" ),
			"popular_items" => __( "Popular Origins", "sage" ),
			"separate_items_with_commas" => __( "Separate Origins with commas", "sage" ),
			"add_or_remove_items" => __( "Add or remove Origins", "sage" ),
			"choose_from_most_used" => __( "Choose from the most used Origins", "sage" ),
			"not_found" => __( "No Origins found", "sage" ),
			"no_terms" => __( "No Origins", "sage" ),
			"items_list_navigation" => __( "Origins list navigation", "sage" ),
			"items_list" => __( "Origins list", "sage" ),
		],
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'origin', 'with_front' => false, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "origin",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "origin", [ "tnf_name" ], $args );

	/**
	 * Taxonomy: Genders.
	 */

	$args = [
		"label" => __( "Genders", "sage" ),
		"labels" => $labels = [
			"name" => __( "Genders", "sage" ),
			"singular_name" => __( "Gender", "sage" ),
		],
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'gender', 'with_front' => false, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "gender",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "gender", [ "tnf_name" ], $args );

	/**
	 * Taxonomy: Types.
	 */

	$args = [
		"label" => __( "Types", "sage" ),
		"labels" => [
			"name" => __( "Types", "sage" ),
			"singular_name" => __( "Type", "sage" ),
			"menu_name" => __( "Types", "sage" ),
			"all_items" => __( "All Types", "sage" ),
			"edit_item" => __( "Edit Type", "sage" ),
			"view_item" => __( "View Type", "sage" ),
			"update_item" => __( "Update Type name", "sage" ),
			"add_new_item" => __( "Add new Type", "sage" ),
			"new_item_name" => __( "New Type name", "sage" ),
			"parent_item" => __( "Parent Type", "sage" ),
			"parent_item_colon" => __( "Parent Type:", "sage" ),
			"search_items" => __( "Search Types", "sage" ),
			"popular_items" => __( "Popular Types", "sage" ),
			"separate_items_with_commas" => __( "Separate Types with commas", "sage" ),
			"add_or_remove_items" => __( "Add or remove Types", "sage" ),
			"choose_from_most_used" => __( "Choose from the most used Types", "sage" ),
			"not_found" => __( "No Types found", "sage" ),
			"no_terms" => __( "No Types", "sage" ),
			"items_list_navigation" => __( "Types list navigation", "sage" ),
			"items_list" => __( "Types list", "sage" ),
		],
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'nametype', 'with_front' => false, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "nametype",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "nametype", [ "tnf_name" ], $args );

	/**
	 * Taxonomy: Groupings.
	 */

	$args = [
		"label" => __( "Groupings", "sage" ),
		"labels" => [
			"name" => __( "Groupings", "sage" ),
			"singular_name" => __( "Grouping", "sage" ),
			"menu_name" => __( "Groupings", "sage" ),
			"all_items" => __( "All Groupings", "sage" ),
			"edit_item" => __( "Edit Grouping", "sage" ),
			"view_item" => __( "View Grouping", "sage" ),
			"update_item" => __( "Update Grouping name", "sage" ),
			"add_new_item" => __( "Add new Grouping", "sage" ),
			"new_item_name" => __( "New Grouping name", "sage" ),
			"parent_item" => __( "Parent Grouping", "sage" ),
			"parent_item_colon" => __( "Parent Grouping:", "sage" ),
			"search_items" => __( "Search Groupings", "sage" ),
			"popular_items" => __( "Popular Groupings", "sage" ),
			"separate_items_with_commas" => __( "Separate Groupings with commas", "sage" ),
			"add_or_remove_items" => __( "Add or remove Groupings", "sage" ),
			"choose_from_most_used" => __( "Choose from the most used Groupings", "sage" ),
			"not_found" => __( "No Groupings found", "sage" ),
			"no_terms" => __( "No Groupings", "sage" ),
			"items_list_navigation" => __( "Groupings list navigation", "sage" ),
			"items_list" => __( "Groupings list", "sage" ),
			"back_to_items" => __( "Back to Groupings", "sage" ),
		],
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'grouping', 'with_front' => false, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "grouping",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "grouping", [ "tnf_name" ], $args );

	/**
	 * Taxonomy: Alternate Spellings.
	 */

	$args = [
		"label" => __( "Alternate Spellings", "sage" ),
		"labels" => [
			"name" => __( "Alternate Spellings", "sage" ),
			"singular_name" => __( "Alternate Spelling", "sage" ),
			"menu_name" => __( "Alternate Spellings", "sage" ),
			"all_items" => __( "All Alternate Spellings", "sage" ),
			"edit_item" => __( "Edit Alternate Spelling", "sage" ),
			"view_item" => __( "View Alternate Spelling", "sage" ),
			"update_item" => __( "Update Alternate Spelling name", "sage" ),
			"add_new_item" => __( "Add new Alternate Spelling", "sage" ),
			"new_item_name" => __( "New Alternate Spelling name", "sage" ),
			"parent_item" => __( "Parent Alternate Spelling", "sage" ),
			"parent_item_colon" => __( "Parent Alternate Spelling:", "sage" ),
			"search_items" => __( "Search Alternate Spellings", "sage" ),
			"popular_items" => __( "Popular Alternate Spellings", "sage" ),
			"separate_items_with_commas" => __( "Separate Alternate Spellings with commas", "sage" ),
			"add_or_remove_items" => __( "Add or remove Alternate Spellings", "sage" ),
			"choose_from_most_used" => __( "Choose from the most used Alternate Spellings", "sage" ),
			"not_found" => __( "No Alternate Spellings found", "sage" ),
			"no_terms" => __( "No Alternate Spellings", "sage" ),
			"items_list_navigation" => __( "Alternate Spellings list navigation", "sage" ),
			"items_list" => __( "Alternate Spellings list", "sage" ),
			"back_to_items" => __( "Back to Alternate Spellings", "sage" ),
		],
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'altspelling', 'with_front' => false, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => true,
		"rest_base" => "altspelling",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "altspelling", [ "tnf_name" ], $args );

	/**
	 * Taxonomy: First Initials.
	 */

	$args = [
		"label" => __( "First Initials", "sage" ),
		"labels" => [
			"name" => __( "First Initials", "sage" ),
			"singular_name" => __( "First Initial", "sage" ),
			"menu_name" => __( "First Initials", "sage" ),
			"all_items" => __( "All First Initials", "sage" ),
			"edit_item" => __( "Edit First Initial", "sage" ),
			"view_item" => __( "View First Initial", "sage" ),
			"update_item" => __( "Update First Initial name", "sage" ),
			"add_new_item" => __( "Add new First Initial", "sage" ),
			"new_item_name" => __( "New First Initial name", "sage" ),
			"parent_item" => __( "Parent First Initial", "sage" ),
			"parent_item_colon" => __( "Parent First Initial:", "sage" ),
			"search_items" => __( "Search First Initials", "sage" ),
			"popular_items" => __( "Popular First Initials", "sage" ),
			"separate_items_with_commas" => __( "Separate First Initials with commas", "sage" ),
			"add_or_remove_items" => __( "Add or remove First Initials", "sage" ),
			"choose_from_most_used" => __( "Choose from the most used First Initials", "sage" ),
			"not_found" => __( "No First Initials found", "sage" ),
			"no_terms" => __( "No First Initials", "sage" ),
			"items_list_navigation" => __( "First Initials list navigation", "sage" ),
			"items_list" => __( "First Initials list", "sage" ),
			"back_to_items" => __( "Back to First Initials", "sage" ),
		],
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'firstinitial', 'with_front' => false, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "firstinitial",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "firstinitial", [ "tnf_name" ], $args );
	/**
	 * Taxonomy: First Initials.
	 */

	$args = [
		"label" => __( "Name Tags", "sage" ),
		"labels" => [
			"name" => __( "Name Tags", "sage" ),
			"singular_name" => __( "Name Tag", "sage" ),
		],
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'tags', 'with_front' => false, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "tnf_tags",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy( "nametag", [ "tnf_name" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes' );

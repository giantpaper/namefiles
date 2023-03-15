<?php

function cptui_register_my_cpts() {

	/**
	 * Post Type: Names.
	 */

	$labels = [
		"name" => __( "Names", "sage" ),
		"singular_name" => __( "Name", "sage" ),
		"menu_name" => __( "Names Old", "sage" ),
		"all_items" => __( "All Names", "sage" ),
		"add_new" => __( "Add new", "sage" ),
		"add_new_item" => __( "Add new Name", "sage" ),
		"edit_item" => __( "Edit Name", "sage" ),
		"new_item" => __( "New Name", "sage" ),
		"view_item" => __( "View Name", "sage" ),
		"view_items" => __( "View Names", "sage" ),
		"search_items" => __( "Search Names", "sage" ),
		"not_found" => __( "No Names found", "sage" ),
		"not_found_in_trash" => __( "No Names found in trash", "sage" ),
		"parent" => __( "Parent Name:", "sage" ),
		"featured_image" => __( "Featured image for this Name", "sage" ),
		"set_featured_image" => __( "Set featured image for this Name", "sage" ),
		"remove_featured_image" => __( "Remove featured image for this Name", "sage" ),
		"use_featured_image" => __( "Use as featured image for this Name", "sage" ),
		"archives" => __( "Name archives", "sage" ),
		"insert_into_item" => __( "Insert into Name", "sage" ),
		"uploaded_to_this_item" => __( "Upload to this Name", "sage" ),
		"filter_items_list" => __( "Filter Names list", "sage" ),
		"items_list_navigation" => __( "Names list navigation", "sage" ),
		"items_list" => __( "Names list", "sage" ),
		"attributes" => __( "Names attributes", "sage" ),
		"name_admin_bar" => __( "Name", "sage" ),
		"item_published" => __( "Name published", "sage" ),
		"item_published_privately" => __( "Name published privately.", "sage" ),
		"item_reverted_to_draft" => __( "Name reverted to draft.", "sage" ),
		"item_scheduled" => __( "Name scheduled", "sage" ),
		"item_updated" => __( "Name updated.", "sage" ),
		"parent_item_colon" => __( "Parent Name:", "sage" ),
	];

	$args = [
		"label" => __( "Names", "sage" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"rest_namespace" => "wp/v2",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"can_export" => true,
		"rewrite" => [ "slug" => "name", "with_front" => false ],
		"query_var" => true,
		"menu_position" => 6,
		"menu_icon" => "dashicons-id",
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "name", $args );
}

add_action( 'init', 'cptui_register_my_cpts' );

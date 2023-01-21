<?php

// =============================================================================
// CUSTOM POST TYPE: FCN_STORY
// =============================================================================

/**
 * Register custom post type fcn_story
 *
 * @since Fictioneer 1.0
 */

function fictioneer_fcn_story_post_type() {
	$labels = array(
		'name'                  => _x( 'Stories', 'Post type general name', 'fictioneer' ),
		'singular_name'         => _x( 'Story', 'Post type singular name', 'fictioneer' ),
		'menu_name'             => __( 'Stories', 'fictioneer' ),
		'name_admin_bar'        => __( 'Story', 'fictioneer' ),
		'archives'              => __( 'Story Archives', 'fictioneer' ),
		'attributes'            => __( 'Story Attributes', 'fictioneer' ),
		'all_items'             => __( 'All Stories', 'fictioneer' ),
		'add_new_item'          => __( 'Add New Story', 'fictioneer' ),
		'add_new'               => __( 'Add New', 'fictioneer' ),
		'new_item'              => __( 'New Story', 'fictioneer' ),
		'edit_item'             => __( 'Edit Story', 'fictioneer' ),
		'update_item'           => __( 'Update Story', 'fictioneer' ),
		'view_item'             => __( 'View Story', 'fictioneer' ),
		'view_items'            => __( 'View Stories', 'fictioneer' ),
		'search_items'          => __( 'Search Stories', 'fictioneer' ),
		'not_found'             => __( 'No stories found', 'fictioneer' ),
		'not_found_in_trash'    => __( 'No stories found in Trash', 'fictioneer' ),
		'featured_image'        => __( 'Story Cover Image', 'fictioneer' ),
		'set_featured_image'    => __( 'Set cover image', 'fictioneer' ),
		'remove_featured_image' => __( 'Remove cover image', 'fictioneer' ),
		'use_featured_image'    => __( 'Use as cover image', 'fictioneer' ),
		'insert_into_item'      => __( 'Insert into story', 'fictioneer' ),
		'uploaded_to_this_item' => __( 'Uploaded to this story', 'fictioneer' ),
		'items_list'            => __( 'Stories list', 'fictioneer' ),
		'items_list_navigation' => __( 'Stories list navigation', 'fictioneer' ),
		'filter_items_list'     => __( 'Filter stories list', 'fictioneer' ),
	);

	$args = array(
		'label'                 => __( 'Story', 'fictioneer' ),
		'description'           => __( 'Holds stories and details about them.', 'fictioneer' ),
		'labels'                => $labels,
		'menu_icon'							=> 'dashicons-book',
		'supports'              => array( 'title', 'author', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		'taxonomies'            => array( 'category', 'post_tag', 'fcn_fandom', 'fcn_character', 'fcn_genre', 'fcn_content_warning' ),
		'hierarchical'          => false,
		'public'                => true,
    'rewrite'               => array( 'slug' => 'story' ),
    'show_in_rest'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);

	register_post_type( 'fcn_story', $args );
}
add_action( 'init', 'fictioneer_fcn_story_post_type', 0 );

// =============================================================================
// CUSTOM POST TYPE: FCN_CHAPTER
// =============================================================================

/**
 * Register custom post type fcn_chapter
 *
 * @since Fictioneer 1.0
 */

function fictioneer_fcn_chapter_post_type() {
	$labels = array(
		'name'                  => _x( 'Chapters', 'Post type general name', 'fictioneer' ),
		'singular_name'         => _x( 'Chapter', 'Post type singular name', 'fictioneer' ),
		'menu_name'             => __( 'Chapters', 'fictioneer' ),
		'name_admin_bar'        => __( 'Chapter', 'fictioneer' ),
		'archives'              => __( 'Chapter Archives', 'fictioneer' ),
		'attributes'            => __( 'Chapter Attributes', 'fictioneer' ),
		'all_items'             => __( 'All Chapters', 'fictioneer' ),
		'add_new_item'          => __( 'Add New Chapter', 'fictioneer' ),
		'add_new'               => __( 'Add New', 'fictioneer' ),
		'new_item'              => __( 'New Chapter', 'fictioneer' ),
		'edit_item'             => __( 'Edit Chapter', 'fictioneer' ),
		'update_item'           => __( 'Update Chapter', 'fictioneer' ),
		'view_item'             => __( 'View Chapter', 'fictioneer' ),
		'view_items'            => __( 'View Chapters', 'fictioneer' ),
		'search_items'          => __( 'Search Chapters', 'fictioneer' ),
		'not_found'             => __( 'No chapters found', 'fictioneer' ),
		'not_found_in_trash'    => __( 'No chapters found in Trash', 'fictioneer' ),
		'featured_image'        => __( 'Chapter Cover Image', 'fictioneer' ),
		'set_featured_image'    => __( 'Set cover image', 'fictioneer' ),
		'remove_featured_image' => __( 'Remove cover image', 'fictioneer' ),
		'use_featured_image'    => __( 'Use as cover image', 'fictioneer' ),
		'insert_into_item'      => __( 'Insert into chapter', 'fictioneer' ),
		'uploaded_to_this_item' => __( 'Uploaded to this chapter', 'fictioneer' ),
		'items_list'            => __( 'Chapters list', 'fictioneer' ),
		'items_list_navigation' => __( 'Chapters list navigation', 'fictioneer' ),
		'filter_items_list'     => __( 'Filter chapters list', 'fictioneer' ),
	);
	$args = array(
		'label'                 => __( 'Chapter', 'fictioneer' ),
		'description'           => __( 'Holds chapters and details about them.', 'fictioneer' ),
		'labels'                => $labels,
		'menu_icon'							=> 'dashicons-text-page',
		'supports'              => array( 'title', 'author', 'editor', 'excerpt', 'thumbnail', 'comments', 'revisions' ),
		'taxonomies'            => array( 'category', 'post_tag', 'fcn_fandom', 'fcn_character', 'fcn_genre', 'fcn_content_warning' ),
		'hierarchical'          => false,
		'public'                => true,
    'rewrite'               => array( 'slug' => 'chapter' ),
    'show_in_rest'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 6,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'fcn_chapter', $args );
}
add_action( 'init', 'fictioneer_fcn_chapter_post_type', 0 );

// =============================================================================
// CUSTOM POST TYPE: FCN_COLLECTION
// =============================================================================

/**
 * Register custom post type fcn_collection
 *
 * @since Fictioneer 4.0
 */

function fictioneer_fcn_collection_post_type() {
	$labels = array(
		'name'                  => _x( 'Collections', 'Post type general name', 'fictioneer' ),
		'singular_name'         => _x( 'Collection', 'Post type singular name', 'fictioneer' ),
		'menu_name'             => __( 'Collections', 'fictioneer' ),
		'name_admin_bar'        => __( 'Collection', 'fictioneer' ),
		'archives'              => __( 'Collection Archives', 'fictioneer' ),
		'attributes'            => __( 'Collection Attributes', 'fictioneer' ),
		'all_items'             => __( 'All Collections', 'fictioneer' ),
		'add_new_item'          => __( 'Add New Collection', 'fictioneer' ),
		'add_new'               => __( 'Add New', 'fictioneer' ),
		'new_item'              => __( 'New Collection', 'fictioneer' ),
		'edit_item'             => __( 'Edit Collection', 'fictioneer' ),
		'update_item'           => __( 'Update Collection', 'fictioneer' ),
		'view_item'             => __( 'View Collection', 'fictioneer' ),
		'view_items'            => __( 'View Collections', 'fictioneer' ),
		'search_items'          => __( 'Search Collections', 'fictioneer' ),
		'not_found'             => __( 'No collections found', 'fictioneer' ),
		'not_found_in_trash'    => __( 'No collections found in Trash', 'fictioneer' ),
		'featured_image'        => __( 'Collection Cover Image', 'fictioneer' ),
		'set_featured_image'    => __( 'Set cover image', 'fictioneer' ),
		'remove_featured_image' => __( 'Remove cover image', 'fictioneer' ),
		'use_featured_image'    => __( 'Use as cover image', 'fictioneer' ),
		'insert_into_item'      => __( 'Insert into collection', 'fictioneer' ),
		'uploaded_to_this_item' => __( 'Uploaded to this collection', 'fictioneer' ),
		'items_list'            => __( 'Collections list', 'fictioneer' ),
		'items_list_navigation' => __( 'Collections list navigation', 'fictioneer' ),
		'filter_items_list'     => __( 'Filter collections list', 'fictioneer' ),
	);
	$args = array(
		'label'                 => __( 'Collection', 'fictioneer' ),
		'description'           => __( 'Collections of stories, chapters, and recommendations.', 'fictioneer' ),
		'labels'                => $labels,
		'menu_icon'							=> 'dashicons-category',
		'supports'              => array( 'title', 'author', 'editor', 'thumbnail' ),
		'taxonomies'            => array( 'category', 'post_tag', 'fcn_fandom', 'fcn_character', 'fcn_genre', 'fcn_content_warning' ),
		'hierarchical'          => false,
		'public'                => true,
    'rewrite'               => array( 'slug' => 'collection' ),
    'show_in_rest'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 7,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'fcn_collection', $args );
}
add_action( 'init', 'fictioneer_fcn_collection_post_type', 0 );

// =============================================================================
// CUSTOM POST TYPE: FCN_RECOMMENDATION
// =============================================================================

/**
 * Register custom post type fcn_recommendation
 *
 * @since Fictioneer 3.0
 */

function fictioneer_fcn_recommendation_post_type() {
	$labels = array(
		'name'                  => _x( 'Recommendations', 'Post type general name', 'fictioneer' ),
		'singular_name'         => _x( 'Recommendation', 'Post type singular name', 'fictioneer' ),
		'menu_name'             => __( 'Recommend.', 'fictioneer' ),
		'name_admin_bar'        => __( 'Recommendation', 'fictioneer' ),
		'archives'              => __( 'Recommendation Archives', 'fictioneer' ),
		'attributes'            => __( 'Recommendation Attributes', 'fictioneer' ),
		'all_items'             => __( 'All Recommend.', 'fictioneer' ),
		'add_new_item'          => __( 'Add New Recommendation', 'fictioneer' ),
		'add_new'               => __( 'Add New', 'fictioneer' ),
		'new_item'              => __( 'New Recommendation', 'fictioneer' ),
		'edit_item'             => __( 'Edit Recommendation', 'fictioneer' ),
		'update_item'           => __( 'Update Recommendation', 'fictioneer' ),
		'view_item'             => __( 'View Recommendation', 'fictioneer' ),
		'view_items'            => __( 'View Recommendations', 'fictioneer' ),
		'search_items'          => __( 'Search Recommendations', 'fictioneer' ),
		'not_found'             => __( 'No recommendations found', 'fictioneer' ),
		'not_found_in_trash'    => __( 'No recommendations found in Trash', 'fictioneer' ),
		'featured_image'        => __( 'Recommendation Cover Image', 'fictioneer' ),
		'set_featured_image'    => __( 'Set cover image', 'fictioneer' ),
		'remove_featured_image' => __( 'Remove cover image', 'fictioneer' ),
		'use_featured_image'    => __( 'Use as cover image', 'fictioneer' ),
		'insert_into_item'      => __( 'Insert into recommendation', 'fictioneer' ),
		'uploaded_to_this_item' => __( 'Uploaded to this recommendation', 'fictioneer' ),
		'items_list'            => __( 'Recommendations list', 'fictioneer' ),
		'items_list_navigation' => __( 'Recommendations list navigation', 'fictioneer' ),
		'filter_items_list'     => __( 'Filter recommendations list', 'fictioneer' ),
	);
	$args = array(
		'label'                 => __( 'Recommendation', 'fictioneer' ),
		'description'           => __( 'Recommendations for external stories.', 'fictioneer' ),
		'labels'                => $labels,
		'menu_icon'							=> 'dashicons-star-filled',
		'supports'              => array( 'title', 'author', 'editor', 'excerpt', 'thumbnail' ),
		'taxonomies'            => array( 'category', 'post_tag', 'fcn_fandom', 'fcn_character', 'fcn_genre', 'fcn_content_warning' ),
		'hierarchical'          => false,
		'public'                => true,
    'rewrite'               => array( 'slug' => 'recommendation' ),
    'show_in_rest'          => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 8,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'fcn_recommendation', $args );
}
add_action( 'init', 'fictioneer_fcn_recommendation_post_type', 0 );

// =============================================================================
// CUSTOM TAXONOMY: FCN_GENRE
// =============================================================================

/**
 * Register custom taxonomy fcn_genre
 *
 * @since Fictioneer 4.3
 */

function fictioneer_add_genre_taxonomy() {
  $labels = array(
    'name'              => _x( 'Genres', 'taxonomy general name', 'textdomain' ),
    'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'textdomain' ),
    'menu_name'         => __( 'Genres', 'text_domain' ),
    'search_items'      => __( 'Search Genres', 'textdomain' ),
    'all_items'         => __( 'All Genres', 'textdomain' ),
    'parent_item'       => __( 'Parent Genre', 'textdomain' ),
    'parent_item_colon' => __( 'Parent Genre:', 'textdomain' ),
    'edit_item'         => __( 'Edit Genre', 'textdomain' ),
    'update_item'       => __( 'Update Genre', 'textdomain' ),
    'add_new_item'      => __( 'Add New Genre', 'textdomain' ),
    'new_item_name'     => __( 'New Genre Name', 'textdomain' )
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'show_in_rest'      => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'genre' ),
  );
  register_taxonomy( 'fcn_genre', array( 'fcn_chapter', 'fcn_story', 'fcn_collection', 'fcn_recommendation' ), $args );
}
add_action( 'init', 'fictioneer_add_genre_taxonomy', 0 );

// =============================================================================
// CUSTOM TAXONOMY: FCN_FANDOM
// =============================================================================

/**
 * Register custom taxonomy fcn_fandom
 *
 * @since Fictioneer 4.0
 */

function fictioneer_add_fandom_taxonomy() {
  $labels = array(
    'name'              => _x( 'Fandoms', 'taxonomy general name', 'textdomain' ),
    'singular_name'     => _x( 'Fandom', 'taxonomy singular name', 'textdomain' ),
    'menu_name'         => __( 'Fandoms', 'text_domain' ),
    'search_items'      => __( 'Search Fandoms', 'textdomain' ),
    'all_items'         => __( 'All Fandoms', 'textdomain' ),
    'parent_item'       => __( 'Parent Fandom', 'textdomain' ),
    'parent_item_colon' => __( 'Parent Fandom:', 'textdomain' ),
    'edit_item'         => __( 'Edit Fandom', 'textdomain' ),
    'update_item'       => __( 'Update Fandom', 'textdomain' ),
    'add_new_item'      => __( 'Add New Fandom', 'textdomain' ),
    'new_item_name'     => __( 'New Fandom Name', 'textdomain' )
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => false,
    'show_in_rest'      => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'fandom' ),
  );
  register_taxonomy( 'fcn_fandom', array( 'fcn_chapter', 'fcn_story', 'fcn_collection', 'fcn_recommendation' ), $args );
}
add_action( 'init', 'fictioneer_add_fandom_taxonomy', 0 );

// =============================================================================
// CUSTOM TAXONOMY: FCN_CHARACTER
// =============================================================================

/**
 * Register custom taxonomy fcn_character
 *
 * @since Fictioneer 4.3
 */

function fictioneer_add_character_taxonomy() {
  $labels = array(
    'name'              => _x( 'Characters', 'taxonomy general name', 'textdomain' ),
    'singular_name'     => _x( 'Character', 'taxonomy singular name', 'textdomain' ),
    'menu_name'         => __( 'Characters', 'text_domain' ),
    'search_items'      => __( 'Search Characters', 'textdomain' ),
    'all_items'         => __( 'All Characters', 'textdomain' ),
    'parent_item'       => __( 'Parent Character', 'textdomain' ),
    'parent_item_colon' => __( 'Parent Character:', 'textdomain' ),
    'edit_item'         => __( 'Edit Character', 'textdomain' ),
    'update_item'       => __( 'Update Character', 'textdomain' ),
    'add_new_item'      => __( 'Add New Character', 'textdomain' ),
    'new_item_name'     => __( 'New Character Name', 'textdomain' )
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => false,
    'show_in_rest'      => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'character' ),
  );
  register_taxonomy( 'fcn_character', array( 'fcn_chapter', 'fcn_story', 'fcn_collection', 'fcn_recommendation' ), $args );
}
add_action( 'init', 'fictioneer_add_character_taxonomy', 0 );

// =============================================================================
// CUSTOM TAXONOMY: FCN_CONTENT_WARNING
// =============================================================================

/**
 * Register custom taxonomy fcn_content_warning
 *
 * @since Fictioneer 4.7
 */

function fictioneer_add_content_warning_taxonomy() {
  $labels = array(
    'name'              => _x( 'Content Warnings', 'taxonomy general name', 'textdomain' ),
    'singular_name'     => _x( 'Content Warning', 'taxonomy singular name', 'textdomain' ),
    'menu_name'         => __( 'Content Warnings', 'text_domain' ),
    'search_items'      => __( 'Search Content Warnings', 'textdomain' ),
    'all_items'         => __( 'All Content Warnings', 'textdomain' ),
    'parent_item'       => __( 'Parent Content Warning', 'textdomain' ),
    'parent_item_colon' => __( 'Parent Content Warning:', 'textdomain' ),
    'edit_item'         => __( 'Edit Content Warning', 'textdomain' ),
    'update_item'       => __( 'Update Content Warning', 'textdomain' ),
    'add_new_item'      => __( 'Add New Content Warning', 'textdomain' ),
    'new_item_name'     => __( 'New Content Warning Name', 'textdomain' )
  );
  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => false,
    'show_in_rest'      => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'content-warning' ),
  );
  register_taxonomy( 'fcn_content_warning', array( 'fcn_chapter', 'fcn_story', 'fcn_collection', 'fcn_recommendation' ), $args );
}
add_action( 'init', 'fictioneer_add_content_warning_taxonomy', 0 );

?>

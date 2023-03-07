<?php

// =============================================================================
// SETUP
// =============================================================================

define( 'FICTIONEER_OPTIONS', array(
  'booleans' => array(
    'fictioneer_enable_maintenance_mode' => array(
      'name' => 'fictioneer_enable_maintenance_mode',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable maintenance mode', 'fictioneer' ),
      'default' => false
		),
		'fictioneer_light_mode_as_default' => array(
      'name' => 'fictioneer_light_mode_as_default',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable light mode as default', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_show_authors' => array(
      'name' => 'fictioneer_show_authors',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Display authors on cards and posts', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_hide_chapter_icons' => array(
      'name' => 'fictioneer_hide_chapter_icons',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Hide chapter icons', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_hide_taxonomies_on_story_cards' => array(
      'name' => 'fictioneer_hide_taxonomies_on_story_cards',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Hide taxonomies on story cards', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_hide_taxonomies_on_chapter_cards' => array(
      'name' => 'fictioneer_hide_taxonomies_on_chapter_cards',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Hide taxonomies on chapter cards', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_hide_taxonomies_on_recommendation_cards' => array(
      'name' => 'fictioneer_hide_taxonomies_on_recommendation_cards',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Hide taxonomies on recommendation cards', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_show_tags_on_story_cards' => array(
      'name' => 'fictioneer_show_tags_on_story_cards',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Show tags on story cards', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_show_tags_on_chapter_cards' => array(
      'name' => 'fictioneer_show_tags_on_chapter_cards',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Show tags on chapter cards', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_show_tags_on_recommendation_cards' => array(
      'name' => 'fictioneer_show_tags_on_recommendation_cards',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Show tags on recommendation cards', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_hide_taxonomies_on_pages' => array(
      'name' => 'fictioneer_hide_taxonomies_on_pages',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Hide taxonomies on pages', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_hide_tags_on_pages' => array(
      'name' => 'fictioneer_hide_tags_on_pages',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Hide tags on pages', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_hide_content_warnings_on_pages' => array(
      'name' => 'fictioneer_hide_content_warnings_on_pages',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Hide content warnings on pages', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_theme_rss' => array(
      'name' => 'fictioneer_enable_theme_rss',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable theme RSS feeds and buttons', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_oauth' => array(
      'name' => 'fictioneer_enable_oauth',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable OAuth 2.0 authentication', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_lightbox' => array(
      'name' => 'fictioneer_enable_lightbox',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable lightbox', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_bookmarks' => array(
      'name' => 'fictioneer_enable_bookmarks',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable Bookmarks', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_follows' => array(
      'name' => 'fictioneer_enable_follows',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable Follows (requires account)', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_checkmarks' => array(
      'name' => 'fictioneer_enable_checkmarks',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable Checkmarks (requires account)', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_reminders' => array(
      'name' => 'fictioneer_enable_reminders',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable Reminders (requires account)', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_suggestions' => array(
      'name' => 'fictioneer_enable_suggestions',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable Suggestions', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_tts' => array(
      'name' => 'fictioneer_enable_tts',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable Text-To-Speech (experimental)', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_seo' => array(
      'name' => 'fictioneer_enable_seo',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable SEO features', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_sitemap' => array(
      'name' => 'fictioneer_enable_sitemap',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable own sitemap generation', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_epubs' => array(
      'name' => 'fictioneer_enable_epubs',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable ePUB converter (experimental)', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_require_js_to_comment' => array(
      'name' => 'fictioneer_require_js_to_comment',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Require JavaScript to comment', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_ajax_comment_submit' => array(
      'name' => 'fictioneer_enable_ajax_comment_submit',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable AJAX comment submission', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_comment_link_limit' => array(
      'name' => 'fictioneer_enable_comment_link_limit',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Limit comments to [n] link(s) or less', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_comment_toolbar' => array(
      'name' => 'fictioneer_enable_comment_toolbar',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable comment toolbar', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_disable_comment_bbcodes' => array(
      'name' => 'fictioneer_disable_comment_bbcodes',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable comment BBCodes', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_ajax_comment_moderation' => array(
      'name' => 'fictioneer_enable_ajax_comment_moderation',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable AJAX comment moderation', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_custom_badges' => array(
      'name' => 'fictioneer_enable_custom_badges',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable custom badges', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_patreon_badges' => array(
      'name' => 'fictioneer_enable_patreon_badges',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable Patreon badges', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_private_commenting' => array(
      'name' => 'fictioneer_enable_private_commenting',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable private commenting', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_enable_comment_notifications' => array(
      'name' => 'fictioneer_enable_comment_notifications',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable comment reply notifications', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_comment_reporting' => array(
      'name' => 'fictioneer_enable_comment_reporting',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable comment reporting', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_heartbeat' => array(
      'name' => 'fictioneer_disable_heartbeat',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable Heartbeat API', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_remove_head_clutter' => array(
      'name' => 'fictioneer_remove_head_clutter',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Remove clutter from HTML head', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_reduce_admin_bar' => array(
      'name' => 'fictioneer_reduce_admin_bar',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Reduce admin bar items', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_bundle_stylesheets' => array(
      'name' => 'fictioneer_bundle_stylesheets',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Bundle CSS files into one', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_do_not_save_comment_ip' => array(
      'name' => 'fictioneer_do_not_save_comment_ip',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Do not save comment IP addresses', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_block_subscribers_from_admin' => array(
      'name' => 'fictioneer_block_subscribers_from_admin',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Block admin panel access for subscribers', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_logout_redirects_home' => array(
      'name' => 'fictioneer_logout_redirects_home',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Logout redirects Home', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_disable_theme_logout' => array(
      'name' => 'fictioneer_disable_theme_logout',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable theme logout without nonce', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_consent_wrappers' => array(
      'name' => 'fictioneer_consent_wrappers',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Add consent wrappers to embedded content', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_admin_restrict_menus' => array(
      'name' => 'fictioneer_admin_restrict_menus',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Restrict admin menus for non-administrators', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_admin_restrict_private_data' => array(
      'name' => 'fictioneer_admin_restrict_private_data',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Restrict personal data for non-administrators', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_cookie_banner' => array(
      'name' => 'fictioneer_cookie_banner',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable cookie banner and consent function', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_cache_compatibility' => array(
      'name' => 'fictioneer_enable_cache_compatibility',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable cache compatibility mode', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_enable_private_cache_compatibility' => array(
      'name' => 'fictioneer_enable_private_cache_compatibility',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable private cache compatibility mode', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_ajax_comments' => array(
      'name' => 'fictioneer_enable_ajax_comments',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable AJAX comment section', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_comment_callback' => array(
      'name' => 'fictioneer_disable_comment_callback',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable theme comment style (callback)', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_comment_query' => array(
      'name' => 'fictioneer_disable_comment_query',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable theme comment query', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_comment_form' => array(
      'name' => 'fictioneer_disable_comment_form',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable theme comment form', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_comment_pagination' => array(
      'name' => 'fictioneer_disable_comment_pagination',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable theme comment pagination', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_facebook_share' => array(
      'name' => 'fictioneer_disable_facebook_share',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable Facebook share button', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_twitter_share' => array(
      'name' => 'fictioneer_disable_twitter_share',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable Twitter share button', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_tumblr_share' => array(
      'name' => 'fictioneer_disable_tumblr_share',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable Tumblr share button', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_reddit_share' => array(
      'name' => 'fictioneer_disable_reddit_share',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable Reddit share button', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_mastodon_share' => array(
      'name' => 'fictioneer_disable_mastodon_share',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable Mastodon share button', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_telegram_share' => array(
      'name' => 'fictioneer_disable_telegram_share',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable Telegram share button', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_whatsapp_share' => array(
      'name' => 'fictioneer_disable_whatsapp_share',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable Whatsapp share button', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_delete_theme_options_on_deactivation' => array(
      'name' => 'fictioneer_delete_theme_options_on_deactivation',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Delete all settings and theme mods on deactivation', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_remove_wp_svg_filters' => array(
      'name' => 'fictioneer_remove_wp_svg_filters',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Remove global WordPress SVG filters', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_jquery_migrate' => array(
      'name' => 'fictioneer_enable_jquery_migrate',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable jQuery migrate script', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_properties' => array(
      'name' => 'fictioneer_disable_properties',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable Fictioneer CSS properties', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_chapter_groups' => array(
      'name' => 'fictioneer_enable_chapter_groups',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable chapter groups', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_disable_chapter_collapsing' => array(
      'name' => 'fictioneer_disable_chapter_collapsing',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable collapsing of chapters', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_public_cache_compatibility' => array(
      'name' => 'fictioneer_enable_public_cache_compatibility',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable public cache compatibility mode', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_show_full_post_content' => array(
      'name' => 'fictioneer_show_full_post_content',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Display full posts instead of excerpts', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_all_blocks' => array(
      'name' => 'fictioneer_enable_all_blocks',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable all default Gutenberg blocks', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_all_block_styles' => array(
      'name' => 'fictioneer_enable_all_block_styles',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable all default Gutenberg block styles', 'fictioneer' ),
      'default' => false
    ),
		'fictioneer_enable_ajax_nonce' => array(
      'name' => 'fictioneer_enable_ajax_nonce',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable AJAX nonce deferment', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_enable_ajax_authentication' => array(
      'name' => 'fictioneer_enable_ajax_authentication',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable AJAX user authentication', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_admin_reduce_subscriber_profile' => array(
      'name' => 'fictioneer_admin_reduce_subscriber_profile',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Reduce subscriber user profile', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_disable_application_passwords' => array(
      'name' => 'fictioneer_disable_application_passwords',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable application passwords', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_enable_user_comment_editing' => array(
      'name' => 'fictioneer_enable_user_comment_editing',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable comment editing', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_enable_subscriber_self_delete' => array(
      'name' => 'fictioneer_enable_subscriber_self_delete',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Allow subscribers to delete their account', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_disable_html_in_comments' => array(
      'name' => 'fictioneer_disable_html_in_comments',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable HTML in comments for non-administrators', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_enable_ajax_comment_form' => array(
      'name' => 'fictioneer_enable_ajax_comment_form',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable AJAX comment form', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_enable_sticky_comments' => array(
      'name' => 'fictioneer_enable_sticky_comments',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable sticky comments', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_disable_commenting' => array(
      'name' => 'fictioneer_disable_commenting',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable commenting across the site', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_purge_all_caches' => array(
      'name' => 'fictioneer_purge_all_caches',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Purge all caches on content updates', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_disable_theme_search' => array(
      'name' => 'fictioneer_disable_theme_search',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable advanced search', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_disable_contact_forms' => array(
      'name' => 'fictioneer_disable_contact_forms',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Disable theme contact forms', 'fictioneer' ),
      'default' => false
    ),
    'fictioneer_enable_storygraph_api' => array(
      'name' => 'fictioneer_enable_storygraph_api',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_checkbox',
      'label' => __( 'Enable Storygraph API', 'fictioneer' ),
      'default' => false
    )
	),
	'integers' => array(
		'fictioneer_user_profile_page' => array(
      'name' => 'fictioneer_user_profile_page',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_page_id',
      'label' => fcntr( 'account' ),
      'default' => -1
		),
		'fictioneer_bookmarks_page' => array(
      'name' => 'fictioneer_bookmarks_page',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_page_id',
      'label' => fcntr( 'bookmarks' ),
      'default' => -1
		),
		'fictioneer_stories_page' => array(
      'name' => 'fictioneer_stories_page',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_page_id',
      'label' => __( 'Stories', 'fictioneer' ),
      'default' => -1
		),
		'fictioneer_chapters_page' => array(
      'name' => 'fictioneer_chapters_page',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_page_id',
      'label' => __( 'Chapters', 'fictioneer' ),
      'default' => -1
		),
		'fictioneer_recommendations_page' => array(
      'name' => 'fictioneer_recommendations_page',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_page_id',
      'label' => __( 'Recommendations', 'fictioneer' ),
      'default' => -1
		),
    'fictioneer_collections_page' => array(
      'name' => 'fictioneer_collections_page',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_page_id',
      'label' => __( 'Collections', 'fictioneer' ),
      'default' => -1
		),
		'fictioneer_bookshelf_page' => array(
      'name' => 'fictioneer_bookshelf_page',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_page_id',
      'label' => __( 'Bookshelf', 'fictioneer' ),
      'default' => -1
		),
		'fictioneer_404_page' => array(
      'name' => 'fictioneer_404_page',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_page_id',
      'label' => __( '404', 'fictioneer' ),
      'default' => -1
		),
		'fictioneer_comment_report_threshold' => array(
      'name' => 'fictioneer_comment_report_threshold',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_integer_one_up',
      'label' => __( 'Automatic moderation report threshold.', 'fictioneer' ),
      'default' => 10
		),
		'fictioneer_comment_link_limit_threshold' => array(
      'name' => 'fictioneer_comment_link_limit_threshold',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_integer_one_up',
      'label' => __( 'Comment link limit.', 'fictioneer' ),
      'default' => 5
		),
		'fictioneer_words_per_minute' => array(
      'name' => 'fictioneer_words_per_minute',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_words_per_minute',
      'label' => __( 'Calculate reading time with [n] words per minute.', 'fictioneer' ),
      'default' => 200
		),
		'fictioneer_user_comment_edit_time' => array(
      'name' => 'fictioneer_user_comment_edit_time',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_sanitize_integer',
      'label' => __( 'Minutes a comment can be edited. -1 for no limit.', 'fictioneer' ),
      'default' => 15
		)
	),
	'strings' => array(
		'fictioneer_phrase_maintenance' => array(
      'name' => 'fictioneer_phrase_maintenance',
			'group' => 'fictioneer-settings-phrases-group',
			'sanitize_callback' => 'wp_kses_post',
      'label' => __( 'Maintenance Note', 'fictioneer' ),
      'default' => __( 'Website under planned maintenance. Please check back later.', 'fictioneer' ),
			'placeholder' => __( 'Website under planned maintenance. Please check back later.', 'fictioneer' )
    ),
		'fictioneer_phrase_login_modal' => array(
      'name' => 'fictioneer_phrase_login_modal',
			'group' => 'fictioneer-settings-phrases-group',
			'sanitize_callback' => 'wp_kses_post',
      'label' => __( 'Login Modal', 'fictioneer' ),
      'default' => __( '<p>Log in with a social media account to set up a profile. You can change your nickname later.</p>', 'fictioneer' ),
			'placeholder' => __( '<p>Log in with a social media account to set up a profile. You can change your nickname later.</p>', 'fictioneer' )
    ),
		'fictioneer_phrase_cookie_consent_banner' => array(
      'name' => 'fictioneer_phrase_cookie_consent_banner',
			'group' => 'fictioneer-settings-phrases-group',
			'sanitize_callback' => 'fictioneer_validate_phrase_cookie_consent_banner',
      'label' => __( 'Cookie Consent Banner', 'fictioneer' ),
      'default' => __( 'We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. Some features are not available without, but you can limit the site to strictly necessary cookies only. See <a href="[[privacy_policy_url]]" target="_blank" tabindex="1">Privacy Policy</a>.', 'fictioneer' ),
			'placeholder' => __( 'We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. Some features are not available without, but you can limit the site to strictly necessary cookies only. See <a href="[[privacy_policy_url]]" target="_blank" tabindex="1">Privacy Policy</a>.', 'fictioneer' )
    ),
    'fictioneer_phrase_comment_reply_notification' => array(
      'name' => 'fictioneer_phrase_comment_reply_notification',
			'group' => 'fictioneer-settings-phrases-group',
			'sanitize_callback' => 'wp_kses_post',
      'label' => __( 'Comment Reply Notification Email', 'fictioneer' ),
      'default' => __( 'Hello [[comment_name]],<br><br>you have a new reply to your comment in <a href="[[post_url]]">[[post_title]]</a>.<br><br><br><strong>[[reply_name]] replied on [[reply_date]]:</strong><br><br><fieldset>[[reply_content]]</fieldset><br><br><a href="[[unsubscribe_url]]">Unsubscribe from this comment.</a>', 'fictioneer' ),
			'placeholder' => __( 'Hello [[comment_name]],<br><br>you have a new reply to your comment in <a href="[[post_url]]">[[post_title]]</a>.<br><br><br><strong>[[reply_name]] replied on [[reply_date]]:</strong><br><br><fieldset>[[reply_content]]</fieldset><br><br><a href="[[unsubscribe_url]]">Unsubscribe from this comment.</a>', 'fictioneer' )
    ),
		'fictioneer_system_email_address' => array(
      'name' => 'fictioneer_system_email_address',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'fictioneer_validate_email_address',
      'label' => __( 'System Email Address', 'fictioneer' ),
      'default' => '',
			'placeholder' => 'noreply@example.com'
    ),
    'fictioneer_system_email_name' => array(
      'name' => 'fictioneer_system_email_name',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'System Email Name', 'fictioneer' ),
      'default' => '',
			'placeholder' => 'Site Name'
    ),
		'fictioneer_patreon_label' => array(
      'name' => 'fictioneer_patreon_label',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Patreon Badge Label', 'fictioneer' ),
      'default' => '',
			'placeholder' => _x( 'Patron', 'Default Patreon supporter badge label.', 'fictioneer' )
    ),
		'fictioneer_comments_notice' => array(
      'name' => 'fictioneer_comments_notice',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'wp_kses_post',
      'label' => __( 'Comment Section Notice', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_discord_client_id' => array(
      'name' => 'fictioneer_discord_client_id',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Discord Client ID', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_discord_client_secret' => array(
      'name' => 'fictioneer_discord_client_secret',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Discord Client Secret', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_discord_channel_comments_webhook' => array(
      'name' => 'fictioneer_discord_channel_comments_webhook',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Discord Invite Link', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_discord_invite_link' => array(
      'name' => 'fictioneer_discord_invite_link',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Discord Comment Channel Webhook', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_twitch_client_id' => array(
      'name' => 'fictioneer_twitch_client_id',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Twitch Client ID', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_twitch_client_secret' => array(
      'name' => 'fictioneer_twitch_client_secret',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Twitch Client Secret', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_google_client_id' => array(
      'name' => 'fictioneer_google_client_id',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Google Client ID', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_google_client_secret' => array(
      'name' => 'fictioneer_google_client_secret',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Google Client Secret', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_patreon_client_id' => array(
      'name' => 'fictioneer_patreon_client_id',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Patreon Client ID', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_patreon_client_secret' => array(
      'name' => 'fictioneer_patreon_client_secret',
			'group' => 'fictioneer-settings-connections-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Patreon Client Secret', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_log' => array(
      'name' => 'fictioneer_log',
			'group' => '',
			'sanitize_callback' => 'wp_kses_post',
      'label' => __( 'Fictioneer Log', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_subitem_date_format' => array(
      'name' => 'fictioneer_subitem_date_format',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Subitem Long Date Format', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_subitem_short_date_format' => array(
      'name' => 'fictioneer_subitem_short_date_format',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'sanitize_text_field',
      'label' => __( 'Subitem Short Date Format', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    ),
		'fictioneer_contact_email_addresses' => array(
      'name' => 'fictioneer_contact_email_addresses',
			'group' => 'fictioneer-settings-general-group',
			'sanitize_callback' => 'sanitize_textarea_field',
      'label' => __( 'Contact Form Receivers (one email address per line)', 'fictioneer' ),
      'default' => '',
			'placeholder' => ''
    )
	)
));

// =============================================================================
// REGISTER ADMIN SETTINGS
// =============================================================================

/**
 * Registers settings for the Fictioneer theme
 *
 * @since Fictioneer 4.0
 */

function fictioneer_register_settings() {
	// Booleans
	foreach ( FICTIONEER_OPTIONS['booleans'] as $setting ) {
		register_setting(
			$setting['group'],
			$setting['name'],
			array(
				'sanitize_callback' => $setting['sanitize_callback']
			)
		);
	}

	// Integers
	foreach ( FICTIONEER_OPTIONS['integers'] as $setting ) {
		register_setting(
			$setting['group'],
			$setting['name'],
			array(
				'sanitize_callback' => $setting['sanitize_callback']
			)
		);
	}

	// Strings
	foreach ( FICTIONEER_OPTIONS['strings'] as $setting ) {
		register_setting(
			$setting['group'],
			$setting['name'],
			array(
				'sanitize_callback' => $setting['sanitize_callback']
			)
		);
	}
}

// =============================================================================
// SPECIAL SANITIZATION CALLBACKS
// =============================================================================

/**
 * Validates the 'words per minute' setting with fallback
 *
 * @since Fictioneer 4.0
 * @see   fictioneer_sanitize_integer()
 *
 * @param int $input The input value to sanitize.
 *
 * @return int The sanitized integer.
 */

function fictioneer_validate_words_per_minute( $input ) {
	return fictioneer_sanitize_integer( $input, 200 );
}

/**
 * Validates integer to be 1 or more
 *
 * @since Fictioneer 4.6
 * @see   fictioneer_sanitize_integer()
 *
 * @param int $input The input value to sanitize.
 *
 * @return int The sanitized integer.
 */

function fictioneer_validate_integer_one_up( $input ) {
	return fictioneer_sanitize_integer( $input, 1, 1 );
}

/**
 * Checks whether an ID is a valid page ID
 *
 * @since Fictioneer 4.6
 *
 * @param int $input The page ID to be sanitized.
 *
 * @return int The sanitized page ID or -1 if not a page.
 */

function fictioneer_validate_page_id( $input ) {
	return get_post_type( intval( $input ) ) == 'page' ? intval( $input ) : -1;
}

/**
 * Validates an email address
 *
 * @since Fictioneer 4.6
 * @see   sanitize_email()
 *
 * @param int $input The email address to be sanitized.
 *
 * @return string The email address if valid or an empty string if not.
 */

function fictioneer_validate_email_address( $input ) {
	$email = sanitize_email( $input );
	return $email ? $email : '';
}

/**
 * Validates the phrase for the cookie consent banner
 *
 * Checks whether the input is a string and has at least 32 characters,
 * otherwise a default is returned. The content is also cleaned of any
 * problematic HTML.
 *
 * @since Fictioneer 4.6
 * @see   wp_kses_post()
 *
 * @param int $input The content for the cookie consent banner.
 *
 * @return string The sanitized content for the cookie consent banner.
 */

function fictioneer_validate_phrase_cookie_consent_banner( $input ) {
  // Setup
  global $allowedtags;
	$default = __( 'We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. Some features are not available without, but you can limit the site to strictly necessary cookies only. See <a href="[[privacy_policy_url]]" target="_blank" tabindex="1">Privacy Policy</a>.', 'fictioneer' );

  // Return default if input is empty
	if ( ! is_string( $input ) ) return $default;

  // Temporarily allow tabindex attribute
  $allowedtags['a']['tabindex'] = [];

  // Apply KSES
  $output = wp_kses( stripslashes_deep( $input ), $allowedtags );

  // Disallow tabindex attribute
  unset( $allowedtags['a']['tabindex'] );

	// Return
  return strlen( $input ) < 32 ? $default : $output;
}

?>

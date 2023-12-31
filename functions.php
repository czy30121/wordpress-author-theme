<?php

// =============================================================================
// RENDER TIME
// =============================================================================

function fictioneer_measure_render_time() {
  global $render_start_time;
  $render_start_time = microtime( true );
}
// add_action( 'template_redirect', 'fictioneer_measure_render_time' );

function fictioneer_display_render_time() {
  global $render_start_time;
  echo '<!-- Render Time: ' . microtime( true ) - $render_start_time . ' seconds -->';
}
// add_action( 'shutdown', 'fictioneer_display_render_time' );

// =============================================================================
// CONSTANTS/SETTINGS
// =============================================================================

// Version
define( 'FICTIONEER_VERSION', '5.4.6' );
define( 'FICTIONEER_MAJOR_VERSION', '5' );
define( 'FICTIONEER_RELEASE_TAG', 'v5.4.6' );

if ( ! defined( 'CHILD_VERSION' ) ) {
  define( 'CHILD_VERSION', false );
}

if ( ! defined( 'CHILD_NAME' ) ) {
  define( 'CHILD_NAME', false );
}

/*
 * Endpoints
 */

// Endpoint: OAuth 2.0
if ( ! defined( 'FICTIONEER_OAUTH_ENDPOINT' ) ) {
  define( 'FICTIONEER_OAUTH_ENDPOINT', 'oauth2' );
}

// Endpoint: EPUBs
if ( ! defined( 'FICTIONEER_EPUB_ENDPOINT' ) ) {
  define( 'FICTIONEER_EPUB_ENDPOINT', 'download-epub' );
}

// Endpoint: Logout (disable with false)
if ( ! defined( 'FICTIONEER_LOGOUT_ENDPOINT' ) ) {
  define( 'FICTIONEER_LOGOUT_ENDPOINT', 'fictioneer-logout' );
}

/*
 * Strings
 */

// String: CSS name of the primary font
if ( ! defined( 'FICTIONEER_PRIMARY_FONT_CSS' ) ) {
  define( 'FICTIONEER_PRIMARY_FONT_CSS', 'Open Sans' );
}

// String: Display name of the primary font
if ( ! defined( 'FICTIONEER_PRIMARY_FONT_NAME' ) ) {
  define( 'FICTIONEER_PRIMARY_FONT_NAME', 'Open Sans' );
}

// String: Meta charset attribute (skip database call if truthy for better performance)
if ( ! defined( 'FICTIONEER_SITE_CHARSET' ) ) {
  define( 'FICTIONEER_SITE_CHARSET', get_bloginfo( 'charset' ) );
}

// String: Lang attribute (skip database call if truthy for better performance)
if ( ! defined( 'FICTIONEER_SITE_LANGUAGE' ) ) {
  define( 'FICTIONEER_SITE_LANGUAGE', get_bloginfo( 'language' ) );
}

// String: Site name (skip database call if truthy for better performance)
if ( ! defined( 'FICTIONEER_SITE_NAME' ) ) {
  define( 'FICTIONEER_SITE_NAME', get_bloginfo( 'name' ) );
}

// String: Site description (skip database call if truthy for better performance)
if ( ! defined( 'FICTIONEER_SITE_DESCRIPTION' ) ) {
  define( 'FICTIONEER_SITE_DESCRIPTION', get_bloginfo( 'description' ) );
}

// String: TTS regex (used to split text into sentences)
if ( ! defined( 'FICTIONEER_TTS_REGEX' ) ) {
  // Note: Because lookbehind assertions do not work in Safari, the script uses a little
  // detour to preserve punctuation marks: text.replace(regex, '$1|').split('|')
  define( 'FICTIONEER_TTS_REGEX', '([.!?:"\'\u201C\u201D])\s+(?=[A-Z"\'\u201C\u201D])' );
}

/*
 * Date Strings
 */

$short_date = get_option( 'fictioneer_subitem_short_date_format', 'M j' ) ?: 'M j';
$long_date = get_option( 'fictioneer_subitem_date_format', "M j, 'y" ) ?: "M j, 'y";

// String: Latest Updates shortcode list item date format
if ( ! defined( 'FICTIONEER_LATEST_UPDATES_LI_DATE' ) ) {
  define( 'FICTIONEER_LATEST_UPDATES_LI_DATE', $short_date );
}

// String: Latest Updates shortcode footer date format
if ( ! defined( 'FICTIONEER_LATEST_UPDATES_FOOTER_DATE' ) ) {
  define( 'FICTIONEER_LATEST_UPDATES_FOOTER_DATE', $long_date );
}

// String: Latest Chapters shortcode footer date format
if ( ! defined( 'FICTIONEER_LATEST_CHAPTERS_FOOTER_DATE' ) ) {
  define( 'FICTIONEER_LATEST_CHAPTERS_FOOTER_DATE', $long_date );
}

// String: Latest Stories shortcode footer date format
if ( ! defined( 'FICTIONEER_LATEST_STORIES_FOOTER_DATE' ) ) {
  define( 'FICTIONEER_LATEST_STORIES_FOOTER_DATE', $long_date );
}

// String: Story card list item date format
if ( ! defined( 'FICTIONEER_CARD_STORY_LI_DATE' ) ) {
  define( 'FICTIONEER_CARD_STORY_LI_DATE', $long_date );
}

// String: Story card footer date format
if ( ! defined( 'FICTIONEER_CARD_STORY_FOOTER_DATE' ) ) {
  define( 'FICTIONEER_CARD_STORY_FOOTER_DATE', $long_date );
}

// String: Chapter card footer date format
if ( ! defined( 'FICTIONEER_CARD_CHAPTER_FOOTER_DATE' ) ) {
  define( 'FICTIONEER_CARD_CHAPTER_FOOTER_DATE', $long_date );
}

// String: Collection card list item date format
if ( ! defined( 'FICTIONEER_CARD_COLLECTION_LI_DATE' ) ) {
  define( 'FICTIONEER_CARD_COLLECTION_LI_DATE', $long_date );
}

// String: Collection card footer date format
if ( ! defined( 'FICTIONEER_CARD_COLLECTION_FOOTER_DATE' ) ) {
  define( 'FICTIONEER_CARD_COLLECTION_FOOTER_DATE', $long_date );
}

// String: Post card footer date format
if ( ! defined( 'FICTIONEER_CARD_POST_FOOTER_DATE' ) ) {
  define( 'FICTIONEER_CARD_POST_FOOTER_DATE', $long_date );
}

// String: Page card footer date format
if ( ! defined( 'FICTIONEER_CARD_PAGE_FOOTER_DATE' ) ) {
  define( 'FICTIONEER_CARD_PAGE_FOOTER_DATE', $long_date );
}

// String: Story page footer date format below 480px
if ( ! defined( 'FICTIONEER_STORY_FOOTER_B480_DATE' ) ) {
  define( 'FICTIONEER_STORY_FOOTER_B480_DATE', $long_date );
}

/*
 * Integers
 */

// Integer: Commentcode expiration timer in seconds (-1 for infinite)
if ( ! defined( 'FICTIONEER_COMMENTCODE_TTL' ) ) {
  define( 'FICTIONEER_COMMENTCODE_TTL', 600 );
}

// Integer: AJAX cache TTL in milliseconds
if ( ! defined( 'FICTIONEER_AJAX_TTL' ) ) {
  define( 'FICTIONEER_AJAX_TTL', 60000 );
}

// Integer: AJAX login cache TTL in milliseconds
if ( ! defined( 'FICTIONEER_AJAX_LOGIN_TTL' ) ) {
  define( 'FICTIONEER_AJAX_LOGIN_TTL', 15000 );
}

// Integer: AJAX POST debounce rate in milliseconds
if ( ! defined( 'FICTIONEER_AJAX_POST_DEBOUNCE_RATE' ) ) {
  define( 'FICTIONEER_AJAX_POST_DEBOUNCE_RATE', 700 );
}

// Integer: Author search keyword limit (use simple text input if exceeded)
if ( ! defined( 'FICTIONEER_AUTHOR_KEYWORD_SEARCH_LIMIT' ) ) {
  define( 'FICTIONEER_AUTHOR_KEYWORD_SEARCH_LIMIT', 100 );
}

// Integer: Update check timeout
if ( ! defined( 'FICTIONEER_UPDATE_CHECK_TIMEOUT' ) ) {
  define( 'FICTIONEER_UPDATE_CHECK_TIMEOUT', 43200 ); // 12 hours
}

// Integer: Storygraph API cache TTL
if ( ! defined( 'FICTIONEER_API_STORYGRAPH_CACHE_TTL' ) ) {
  define( 'FICTIONEER_API_STORYGRAPH_CACHE_TTL', 3600 );
}

// Integer: Storygraph API number of stories per page
if ( ! defined( 'FICTIONEER_API_STORYGRAPH_STORIES_PER_PAGE' ) ) {
  define( 'FICTIONEER_API_STORYGRAPH_STORIES_PER_PAGE', 10 );
}

// Integer: Maximum number of displayed custom pages
if ( ! defined( 'FICTIONEER_MAX_CUSTOM_PAGES_PER_STORY' ) ) {
  define( 'FICTIONEER_MAX_CUSTOM_PAGES_PER_STORY', 4 );
}

// Integer: The number of chapter before and after folding in chapter lists
if ( ! defined( 'FICTIONEER_CHAPTER_FOLDING_THRESHOLD' ) ) {
  define( 'FICTIONEER_CHAPTER_FOLDING_THRESHOLD', 5 );
}

/*
 * Booleans
 */

// Boolean: Theme cache purging on post update
if ( ! defined( 'FICTIONEER_CACHE_PURGE_ASSIST' ) ) {
  define( 'FICTIONEER_CACHE_PURGE_ASSIST', true );
}

// Boolean: Theme relationship cache purging on post update
if ( ! defined( 'FICTIONEER_RELATIONSHIP_PURGE_ASSIST' ) ) {
  define( 'FICTIONEER_RELATIONSHIP_PURGE_ASSIST', true );
}

// Boolean: Cache chapter lists on story pages as Transients
if ( ! defined( 'FICTIONEER_CHAPTER_LIST_TRANSIENTS' ) ) {
  define( 'FICTIONEER_CHAPTER_LIST_TRANSIENTS', true );
}

// Boolean: Menu items for search
if ( ! defined( 'FICTIONEER_SHOW_SEARCH_IN_MENUS' ) ) {
  define( 'FICTIONEER_SHOW_SEARCH_IN_MENUS', true );
}

// Boolean: Base theme switch in site settings
if ( ! defined( 'FICTIONEER_THEME_SWITCH' ) ) {
  define( 'FICTIONEER_THEME_SWITCH', true );
}

// Boolean: Attachment pages
if ( ! defined( 'FICTIONEER_ATTACHMENT_PAGES' ) ) {
  define( 'FICTIONEER_ATTACHMENT_PAGES', false );
}

// Boolean: Show OAuth ID Hashes (admin only)
if ( ! defined( 'FICTIONEER_SHOW_OAUTH_HASHES' ) ) {
  define( 'FICTIONEER_SHOW_OAUTH_HASHES', false );
}

// Boolean: Show AJAX comment submission disallowed content keys
if ( ! defined( 'FICTIONEER_DISALLOWED_KEY_NOTICE' ) ) {
  define( 'FICTIONEER_DISALLOWED_KEY_NOTICE', true );
}

// Boolean: Only allow assigned chapters in stories
// Warning: The chapter navigation always refers to the parent story!
if ( ! defined( 'FICTIONEER_FILTER_STORY_CHAPTERS' ) ) {
  define( 'FICTIONEER_FILTER_STORY_CHAPTERS', true );
}

// Boolean: Only show the full comment form after clicking into it
if ( ! defined( 'FICTIONEER_COLLAPSE_COMMENT_FORM' ) ) {
  define( 'FICTIONEER_COLLAPSE_COMMENT_FORM', true );
}

// Boolean: Storygraph API image nodes
if ( ! defined( 'FICTIONEER_API_STORYGRAPH_IMAGES' ) ) {
  define( 'FICTIONEER_API_STORYGRAPH_IMAGES', true );
}

// Boolean: Storygraph API hotlink permission
if ( ! defined( 'FICTIONEER_API_STORYGRAPH_HOTLINK' ) ) {
  define( 'FICTIONEER_API_STORYGRAPH_HOTLINK', false );
}

// Boolean: Storygraph API with chapters in /stories
if ( ! defined( 'FICTIONEER_API_STORYGRAPH_CHAPTERS' ) ) {
  define( 'FICTIONEER_API_STORYGRAPH_CHAPTERS', true );
}

// Boolean: Storygraph API Transients caching
if ( ! defined( 'FICTIONEER_API_STORYGRAPH_TRANSIENTS' ) ) {
  define( 'FICTIONEER_API_STORYGRAPH_TRANSIENTS', true );
}

// =============================================================================
// GLOBAL
// =============================================================================

/**
 * Provides various utility functions.
 */

require_once __DIR__ . '/includes/functions/_utility.php';

/**
 * Modify WordPress functions via hooks.
 */

require_once __DIR__ . '/includes/functions/_wordpress_mods.php';

/**
 * Set up the theme customizer.
 */

require_once __DIR__ . '/includes/functions/_customizer.php';

/**
 * Set up the theme.
 */

require_once __DIR__ . '/includes/functions/_theme_setup.php';

/**
 * Configuration for the Advanced Custom Fields plugin.
 */

require_once __DIR__ . '/includes/functions/_acf.php';

/**
 * Add custom post types.
 */

require_once __DIR__ . '/includes/functions/_cpt_and_taxonomies.php';

/**
 * Add custom shortcodes.
 */

require_once __DIR__ . '/includes/functions/_shortcodes.php';

/**
 * Caches and Transients.
 */

require_once __DIR__ . '/includes/functions/_caching_and_transients.php';

/**
 * Generate sitemap.
 */

require_once __DIR__ . '/includes/functions/_sitemap.php';

/**
 * Add SEO features to the site.
 */

require_once __DIR__ . '/includes/functions/_seo.php';

/**
 * Communicate with the Discord API.
 */

require_once __DIR__ . '/includes/functions/_discord.php';

/**
 * Generate ePUBs for stories.
 */

require_once __DIR__ . '/includes/functions/_epub.php';

/**
 * Log-in and register subscribers via OAuth 2.0.
 */

require_once __DIR__ . '/includes/functions/_oauth.php';

/**
 * Handle comments on story pages.
 */

require_once __DIR__ . '/includes/functions/comments/_story_comments.php';

/**
 * Display comments via AJAX.
 */

require_once __DIR__ . '/includes/functions/comments/_comments_ajax.php';

/**
 * Handle comments.
 */

require_once __DIR__ . '/includes/functions/comments/_comments_controller.php';

/**
 * Build comment form.
 */

require_once __DIR__ . '/includes/functions/comments/_comments_form.php';

/**
 * Build comments thread.
 */

require_once __DIR__ . '/includes/functions/comments/_comments_threads.php';

/**
 * Handle comments moderation.
 */

require_once __DIR__ . '/includes/functions/comments/_comments_moderation.php';

/**
 * Add functions for users.
 */

require_once __DIR__ . '/includes/functions/users/_user_data.php';

/**
 * Add functions to handle avatars.
 */

require_once __DIR__ . '/includes/functions/users/_avatars.php';

/**
 * Add the follow feature.
 */

require_once __DIR__ . '/includes/functions/users/_follows.php';

/**
 * Add the bookmarks feature.
 */

require_once __DIR__ . '/includes/functions/users/_bookmarks.php';

/**
 * Add the checkmarks features.
 */

require_once __DIR__ . '/includes/functions/users/_checkmarks.php';

/**
 * Add the reminders feature.
 */

require_once __DIR__ . '/includes/functions/users/_reminders.php';

/**
 * Add privacy and security measures.
 */

require_once __DIR__ . '/includes/functions/users/_privacy_security.php';

/**
 * Add content helper functions.
 */

require_once __DIR__ . '/includes/functions/_content_helpers.php';

/**
 * Add content query functions.
 */

require_once __DIR__ . '/includes/functions/_query_helpers.php';

/**
 * Add content helper functions.
 */

require_once __DIR__ . '/includes/functions/_roles.php';

/**
 * Add forms.
 */

require_once __DIR__ . '/includes/functions/_forms.php';

/**
 * Add search.
 */

require_once __DIR__ . '/includes/functions/_search.php';

/**
 * Add API.
 */

require_once __DIR__ . '/includes/functions/_api.php';

// =============================================================================
// ADMIN ONLY
// =============================================================================

if ( is_admin() ) {

  /**
   * Remove obsolete data and clean up when the theme is deactivated/deleted.
   */

  require_once __DIR__ . '/includes/functions/_cleanup.php';

  /**
   * Add setting page for the theme.
   */

  require_once __DIR__ . '/includes/functions/settings/_settings.php';

  /**
   * Extend user profile in admin panel.
   */

  require_once __DIR__ . '/includes/functions/users/_admin_profile.php';

}

// =============================================================================
// FRONTEND ONLY
// =============================================================================

if ( ! is_admin() ) {

  /**
   * Add general hooks.
   */

  require_once __DIR__ . '/includes/functions/hooks/_general_hooks.php';

  /**
   * Add chapter hooks.
   */

  require_once __DIR__ . '/includes/functions/hooks/_chapter_hooks.php';

  /**
   * Add recommendation hooks.
   */

  require_once __DIR__ . '/includes/functions/hooks/_recommendation_hooks.php';

  /**
   * Add story hooks.
   */

  require_once __DIR__ . '/includes/functions/hooks/_story_hooks.php';

  /**
   * Add post hooks.
   */

  require_once __DIR__ . '/includes/functions/hooks/_post_hooks.php';

  /**
   * Add collection hooks.
   */

  require_once __DIR__ . '/includes/functions/hooks/_collection_hooks.php';

  /**
   * Add profile hooks.
   */

  require_once __DIR__ . '/includes/functions/hooks/_profile_hooks.php';

  /**
   * Add mobile menu hooks.
   */

  require_once __DIR__ . '/includes/functions/hooks/_mobile_menu_hooks.php';

  /**
   * Generate SEO schema graphs.
   */

  if ( get_option( 'fictioneer_enable_seo' ) && ! fictioneer_seo_plugin_active() ) {
    require_once __DIR__ . '/includes/functions/_schemas.php';
  }
}

?>

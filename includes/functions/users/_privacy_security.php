<?php

// =============================================================================
// HIDE PRIVACY SENSITIVE DATA FROM NON-ADMINISTRATORS
// =============================================================================

/**
 * Remove email and name columns from user table
 *
 * @since Fictioneer 4.7
 *
 * @param array $column_headers Columns to show in the user table.
 *
 * @return array $column_headers Reduced columns to show in the user table.
 */

function fictioneer_hide_users_columns( $column_headers ) {
  unset( $column_headers['email'] );
  unset( $column_headers['name'] );
  return $column_headers;
}

/**
 * Remove quick edit from comments table
 *
 * The quick edit form for comments shows unfortunately private data that
 * we want to hide if that setting is enabled.
 *
 * @since Fictioneer 4.7
 *
 * @param array $actions Actions per row in the comments table.
 *
 * @return array $actions Restricted actions per row in the comments table.
 */

function fictioneer_remove_quick_edit( $actions ) {
  unset( $actions['quickedit'] );
  return $actions;
}

/**
 * Remove URL and email fields from comment edit page
 *
 * Since these are not normally accessible, we need to quickly hide them
 * with JavaScript. This is not a great solution but better than nothing.
 *
 * @since Fictioneer 4.7
 */

function fictioneer_hide_private_data() {
  wp_add_inline_script(
    'fictioneer-admin-script',
    "jQuery(function($) {
      $('.editcomment tr:nth-child(3)').remove();
      $('.editcomment tr:nth-child(2)').remove();
    });"
  );
}

/**
 * Add filters and action depending on security settings
 */

if ( get_option( 'fictioneer_admin_restrict_private_data' ) && ! current_user_can( 'administrator' ) ) {
  add_filter( 'manage_users_columns', 'fictioneer_hide_users_columns' );
  add_filter( 'comment_email', '__return_false' );
  add_filter( 'get_comment_author_IP', '__return_empty_string' );
  add_filter( 'comment_row_actions', 'fictioneer_remove_quick_edit' );
  add_action( 'admin_enqueue_scripts', 'fictioneer_hide_private_data' );
}

// =============================================================================
// RESTRICT ADMIN PANEL FOR NON-ADMINISTRATORS
// =============================================================================

/**
 * Remove menu pages from admin panel
 *
 * WordPress does remove most menus for users without the required capabilities,
 * but not all. The same goes for plugins.
 *
 * @since Fictioneer 4.7
 */

function fictioneer_remove_menu_pages() {
  // Default menus
  remove_menu_page( 'tools.php' );
  remove_menu_page( 'plugins.php' );
  remove_menu_page( 'themes.php' );
  remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );

  // Known plugins
  remove_menu_page( 'stc-subscribe-settings' );

  // Is not moderator...
  if ( ! current_user_can( 'moderate_comments' ) ) {
    remove_menu_page( 'edit-comments.php' );
  }
}

/**
 * Restrict menu access for non-administrators
 *
 * This may be somewhat overzealous but ensures that users without the required
 * capabilities have no way to access these admin pages, regardless whether or not
 * they could do anything there.
 *
 * @since Fictioneer 4.7
 */

function fictioneer_restrict_menu_access() {
  // Setup
  $screen = get_current_screen();
  $base = $screen->id;

  // No access for non-administrators...
  if (
    in_array(
      $base,
      ['tools', 'export', 'import', 'site-health', 'export-personal-data', 'erase-personal-data', 'themes', 'customize', 'nav-menus', 'theme-editor', 'users', 'user-new', 'options-general']
    )
  ) {
    wp_die( __( 'Access denied.', 'fictioneer' ) );
  }

  // Is not moderator...
  if ( ! current_user_can( 'moderate_comments' ) ) {
    if ( $base === 'edit-comments' ) {
      wp_die( __( 'Access denied.', 'fictioneer' ) );
    }
  }
}

/**
 * Add filters and action depending on security settings
 */

if ( get_option( 'fictioneer_admin_restrict_menus' ) && ! fictioneer_is_admin( get_current_user_id() ) ) {
  add_action( 'admin_menu', 'fictioneer_remove_menu_pages' );
  add_action( 'current_screen', 'fictioneer_restrict_menu_access' );
}

?>

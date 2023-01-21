<?php

// =============================================================================
// AVATAR FALLBACK
// =============================================================================

if ( ! function_exists( 'fictioneer_avatar_fallback' ) ) {
  /**
   * Add fallback inline script to avatars
   *
   * @since Fictioneer 5.0
   *
   * @param string $avatar      HTML for the avatar.
   * @param string $id_or_email ID or email of the user.
   *
   * @return string HTML with fallback script added.
   */

  function fictioneer_avatar_fallback( $avatar, $id_or_email ) {
    $default_url = get_avatar_url( $id_or_email, ['force_default' => true] );
    return str_replace( '<img', '<img onerror="this.src=\'' . $default_url . '\';this.srcset=\'\';this.onerror=\'\';"', $avatar );
  }
}
add_filter( 'get_avatar' , 'fictioneer_avatar_fallback' , 1 , 2 );

// =============================================================================
// GET CUSTOM AVATAR URL
// =============================================================================

if ( ! function_exists( 'fictioneer_get_custom_avatar_url' ) ) {
  /**
   * Get custom avatar URL
   *
   * @since Fictioneer 4.0
   *
   * @param WP_User $user The user to get the avatar for.
   *
   * @return string|boolean The custom avatar URL or false.
   */

  function fictioneer_get_custom_avatar_url( $user ) {
    // Override default avatar with external avatar if allowed
    if ( $user && is_object( $user ) && ! $user->fictioneer_enforce_gravatar ) {
      $avatar_url = empty( $user->fictioneer_external_avatar_url ) ? null : $user->fictioneer_external_avatar_url;
      if ( $avatar_url ) return $avatar_url;
    }

    return false;
  }
}

// =============================================================================
// GET CUSTOM AVATAR URL
// =============================================================================

if ( ! function_exists( 'fictioneer_get_avatar_url' ) ) {
  /**
   * Filter the avatar URL
   *
   * @since Fictioneer 4.0
   *
   * @param string     $url         The default URL by WordPress.
   * @param int|string $id_or_email User ID or email address.
   * @param WP_User    $args        Additional arguments.
   *
   * @return string The avatar URL.
   */

  function fictioneer_get_avatar_url( $url, $id_or_email, $args ) {
    // Setup
    $user = fictioneer_get_user_by_id_or_email( $id_or_email );
    $custom_avatar = fictioneer_get_custom_avatar_url( $user );

    // Abort conditions...
    if ( $args['force_default'] ) return $url;

    // Check user and permissions
    if ( $user ) {
      $user_disabled = $user->fictioneer_disable_avatar;
      $admin_disabled = $user->fictioneer_admin_disable_avatar;

      if ( $user_disabled || $admin_disabled ) {
        return false;
      }
    }

    // Return custom avatar if set
    if ( $custom_avatar ) return $custom_avatar;

    // Return default avatar
    return $url;
  };
}
add_filter( 'get_avatar_url', 'fictioneer_get_avatar_url', 10, 3 );

// =============================================================================
// GET USER AVATAR URL - AJAX
// =============================================================================

if ( ! function_exists( 'fictioneer_ajax_get_avatar' ) ) {
  /**
   * Get user avatar URL via AJAX
   *
   * @since Fictioneer 4.0
   * @link https://developer.wordpress.org/reference/functions/wp_send_json_success/
   * @link https://developer.wordpress.org/reference/functions/wp_send_json_error/
   * @see fictioneer_get_validated_ajax_user()
   */

  function fictioneer_ajax_get_avatar() {
    // Setup and validations
    $user = fictioneer_get_validated_ajax_user();
    if ( ! $user ) wp_send_json_error( ['error' => __( 'Request did not pass validation.', 'fictioneer' )] );

    // Response
    wp_send_json_success( ['url' => get_avatar_url( $user->ID )] );
  }
}
add_action( 'wp_ajax_fictioneer_ajax_get_avatar', 'fictioneer_ajax_get_avatar' );

?>

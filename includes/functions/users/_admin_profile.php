<?php

// =============================================================================
// UTILITY
// =============================================================================

/**
 * Verify an admin profile action request
 *
 * @since Fictioneer 5.2.5
 *
 * @param string $action Name of the admin profile action.
 */

function fictioneer_verify_admin_profile_action( $action ) {
  // Verify request
  if ( ! check_admin_referer( $action, 'fictioneer_nonce' ) ) {
    wp_die( __( 'Nonce verification failed. Please try again.', 'fictioneer' ) );
  }
}

/**
 * Finish an admin profile action and perform a redirect
 *
 * @since Fictioneer 5.2.5
 *
 * @param string $notice Optional. The notice message to include in the redirect URL.
 * @param string $type   Optional. The type of notice. Default 'success'.
 */

function fictioneer_finish_admin_profile_action( $notice = '', $type = 'success' ) {
  // Setup
  $notice = empty( $notice ) ? [] : array( $type => $notice );

  // Redirect
  wp_safe_redirect( add_query_arg( $notice, wp_get_referer() ) );

  // Terminate
  exit();
}

// =============================================================================
// ADMIN PROFILE ACTIONS
// =============================================================================

/**
 * Unset OAuth
 *
 * @since Fictioneer 5.2.5
 */

function fictioneer_admin_profile_unset_oauth() {
  // Setup
  $channel = sanitize_text_field( $_GET['channel'] ?? '' );

  // Verify request
  fictioneer_verify_admin_profile_action( "admin_oauth_unset_{$channel}" );

  // Continue setup
  $current_user_id = get_current_user_id();
  $profile_user_id = absint( $_GET['profile_user_id'] ?? 0 );
  $target_is_admin = fictioneer_is_admin( $profile_user_id );

  // Guard admins
  if ( $target_is_admin && $current_user_id !== $profile_user_id ) {
    wp_die( __( 'Insufficient permissions.', 'fictioneer' ) );
  }

  // Guard users
  if ( $current_user_id !== $profile_user_id ) {
    wp_die( __( 'Insufficient permissions.', 'fictioneer' ) );
  }

  // Unset connection
  delete_user_meta( $profile_user_id, "fictioneer_{$channel}_id_hash" );

  // Finish
  fictioneer_finish_admin_profile_action( "admin-profile-unset-oauth-{$channel}" );
}
// Not conditional since removing your connection should always be allowed
add_action( 'admin_post_admin_profile_unset_oauth', 'fictioneer_admin_profile_unset_oauth' );

/**
 * Cleat data node
 *
 * @since Fictioneer 5.2.5
 */

function fictioneer_admin_profile_clear_data_node() {
  // Setup
  $node = sanitize_text_field( $_GET['node'] ?? '' );

  // Verify request
  fictioneer_verify_admin_profile_action( "admin_clear_data_node_{$node}" );

  // Continue setup
  $current_user_id = get_current_user_id();
  $profile_user_id = absint( $_GET['profile_user_id'] ?? 0 );
  $target_is_admin = fictioneer_is_admin( $profile_user_id );
  $result = false;

  // Guard admins
  if ( $target_is_admin && ( $current_user_id !== $profile_user_id ) ) {
    wp_die( __( 'Insufficient permissions.', 'fictioneer' ) );
  }

  // Guard users
  if ( $current_user_id !== $profile_user_id ) {
    wp_die( __( 'Insufficient permissions.', 'fictioneer' ) );
  }

  // Clear data
  switch ( $node ) {
    case 'comments':
      $result = fictioneer_soft_delete_user_comments( $profile_user_id );
      $result = is_array( $result ) ? $result['complete'] : $result;
      break;
    case 'comment-subscriptions':
      $result = update_user_meta( $profile_user_id, 'fictioneer_comment_reply_validator', time() );
      break;
    case 'follows':
      $result = update_user_meta( $profile_user_id, 'fictioneer_user_follows', [] );
      update_user_meta( $profile_user_id, 'fictioneer_user_follows_cache', false );
      break;
    case 'reminders':
      $result = update_user_meta( $profile_user_id, 'fictioneer_user_reminders', [] );
      break;
    case 'checkmarks':
      $result = update_user_meta( $profile_user_id, 'fictioneer_user_checkmarks', [] );
      break;
    case 'bookmarks':
      // Bookmarks are only parsed client-side and stored as JSON string
      $result = update_user_meta( $profile_user_id, 'fictioneer_bookmarks', '{}' );
      break;
  }

  // Finish
  if ( ! empty( $result ) ) {
    fictioneer_finish_admin_profile_action( "admin-profile-cleared-data-node-{$node}" );
  } {
    fictioneer_finish_admin_profile_action( "admin-profile-not-cleared-data-node-{$node}", 'failure' );
  }
}
// Not conditional since clearing your data nodes should always be allowed
add_action( 'admin_post_admin_profile_clear_data_node', 'fictioneer_admin_profile_clear_data_node' );

// =============================================================================
// OUTPUT ADMIN PROFILE NOTICES
// =============================================================================

if ( ! defined( 'FICTIONEER_ADMIN_PROFILE_NOTICES' ) ) {
  define(
		'FICTIONEER_ADMIN_PROFILE_NOTICES',
		array(
			'admin-profile-unset-oauth-patreon' => __( 'Patreon connection successfully removed.', 'fictioneer' ),
      'admin-profile-unset-oauth-google' => __( 'Google connection successfully removed.', 'fictioneer' ),
      'admin-profile-unset-oauth-twitch' => __( 'Twitch connection successfully removed.', 'fictioneer' ),
      'admin-profile-unset-oauth-discord' => __( 'Discord connection successfully removed.', 'fictioneer' ),
      'admin-profile-not-cleared-data-node-comments' => __( 'Comments could not be cleared.', 'fictioneer' ),
      'admin-profile-not-cleared-data-node-comment-subscriptions' => __( 'Comment subscriptions could not be cleared.', 'fictioneer' ),
      'admin-profile-not-cleared-data-node-follows' => __( 'Follows could not be cleared.', 'fictioneer' ),
      'admin-profile-not-cleared-data-node-reminders' => __( 'Reminders could not be cleared.', 'fictioneer' ),
      'admin-profile-not-cleared-data-node-checkmarks' => __( 'Checkmarks could not be cleared.', 'fictioneer' ),
      'admin-profile-not-cleared-data-node-bookmarks' => __( 'Bookmarks could not be cleared.', 'fictioneer' ),
      'admin-profile-cleared-data-node-comments' => __( 'Comments successfully cleared.', 'fictioneer' ),
      'admin-profile-cleared-data-node-comment-subscriptions' => __( 'Comment subscriptions successfully cleared.', 'fictioneer' ),
      'admin-profile-not-cleared-data-node-follows' => __( 'Follows successfully cleared.', 'fictioneer' ),
      'admin-profile-cleared-data-node-reminders' => __( 'Reminders successfully cleared.', 'fictioneer' ),
      'admin-profile-cleared-data-node-checkmarks' => __( 'Checkmarks successfully cleared.', 'fictioneer' ),
      'admin-profile-cleared-data-node-bookmarks' => __( 'Bookmarks successfully cleared.', 'fictioneer' ),
      'oauth_already_linked' => __( 'Account already linked to another profile.', 'fictioneer' ),
      'oauth_merged_discord' => __( 'Discord account successfully linked', 'fictioneer' ),
      'oauth_merged_google' => __( 'Google account successfully linked.', 'fictioneer' ),
      'oauth_merged_twitch' => __( 'Twitch account successfully linked.', 'fictioneer' ),
      'oauth_merged_patreon' => __( 'Patreon account successfully linked.', 'fictioneer' ),
		)
	);
}

/**
 * Output admin settings notices
 *
 * @since Fictioneer 5.2.5
 */

function fictioneer_admin_profile_notices() {
  // Get performed action
  $success = $_GET['success'] ?? null;
  $failure = $_GET['failure'] ?? null;

  // Has success notice?
  if ( ! empty( $success ) && isset( FICTIONEER_ADMIN_PROFILE_NOTICES[ $success ] ) ) {
    echo '<div class="notice notice-success is-dismissible"><p>' . FICTIONEER_ADMIN_PROFILE_NOTICES[ $success ] . '</p></div>';
  }

  // Has failure notice?
  if ( ! empty( $failure ) && isset( FICTIONEER_ADMIN_PROFILE_NOTICES[ $failure ] ) ) {
    echo '<div class="notice notice-error is-dismissible"><p>' . FICTIONEER_ADMIN_PROFILE_NOTICES[ $failure ] . '</p></div>';
  }
}
add_action( 'admin_notices', 'fictioneer_admin_profile_notices' );

// =============================================================================
// SHOW CUSTOM FIELDS IN USER PROFILE
// =============================================================================

/**
 * Add custom HTML to the admin user profile page
 *
 * @since Fictioneer 4.0
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

function fictioneer_custom_profile_fields( $profile_user ) {
  // Setup
  $moderation_message = get_the_author_meta( 'fictioneer_admin_moderation_message', $profile_user->ID );

  // Start HTML ---> ?>
  <h2 class="fictioneer-data-heading"><?php _e( 'Fictioneer', 'fictioneer' ) ?></h2>
  <table class="form-table">
    <tbody>
      <?php

      // Display moderation message (if any)
      if ( ! empty( $moderation_message ) ) {
        echo '<p>' . $moderation_message . '</p>';
      }

      // Hook to show fields
      do_action( 'fictioneer_admin_user_sections', $profile_user );

      ?>
    </tbody>
  </table>
  <?php // <--- End HTML
}
add_action( 'show_user_profile', 'fictioneer_custom_profile_fields', 20 );
add_action( 'edit_user_profile', 'fictioneer_custom_profile_fields', 20 );

// =============================================================================
// SHOW FINGERPRINT
// =============================================================================

/**
 * Render fingerprint in admin profile
 *
 * @since Fictioneer 5.2.5
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

function fictioneer_admin_profile_fields_fingerprint( $profile_user ) {
  // Setup
  $sender_is_admin = fictioneer_is_admin( get_current_user_id() );
  $sender_is_owner = $profile_user->ID === get_current_user_id();

  // Guard
  if ( ! $sender_is_admin && ! $sender_is_owner ) return;

  // --- Start HTML ---> ?>
  <tr class="user-fictioneer-fingerprint-wrap">
    <th><label for="fictioneer_support_message"><?php _e( 'Fingerprint', 'fictioneer' ) ?></label></th>
    <td>
      <input type="text" value="<?php echo esc_attr( fictioneer_get_user_fingerprint( $profile_user->ID ) ); ?>" class="regular-text" disabled>
      <p class="description"><?php _e( 'Your unique hash. Used to distinguish commenters.', 'fictioneer' ) ?></p>
    </td>
  </tr>
  <?php // <--- End HTML
}
add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_fields_fingerprint', 5 );

// =============================================================================
// SHOW FLAGS
// =============================================================================

/**
 * Render profile flags in admin profile
 *
 * @since Fictioneer 5.2.5
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

function fictioneer_admin_profile_fields_flags( $profile_user ) {
  // Setup
  $sender_is_admin = fictioneer_is_admin( get_current_user_id() );
  $sender_is_owner = $profile_user->ID === get_current_user_id();

  // Guard
  if ( ! $sender_is_admin && ! $sender_is_owner ) return;

  // Continue setup
  $always_gravatar = get_the_author_meta( 'fictioneer_enforce_gravatar', $profile_user->ID ) ?: false;
  $disable_avatar = get_the_author_meta( 'fictioneer_disable_avatar', $profile_user->ID ) ?: false;
  $hide_badge = get_the_author_meta( 'fictioneer_hide_badge', $profile_user->ID ) ?: false;
  $disable_override_badge = get_the_author_meta( 'fictioneer_disable_badge_override', $profile_user->ID ) ?: false;
  $reply_notifications = get_the_author_meta( 'fictioneer_comment_reply_notifications', $profile_user->ID ) ?: false;

  // --- Start HTML ---> ?>
  <tr class="user-fictioneer-profile-flags-wrap">
    <th><?php _e( 'Profile Flags', 'fictioneer' ) ?></th>
    <td>
      <fieldset>
        <div>
          <label for="fictioneer_enforce_gravatar" class="checkbox-group">
            <input
              name="fictioneer_enforce_gravatar"
              type="checkbox"
              id="fictioneer_enforce_gravatar"
              value="1"
              <?php echo checked( 1, $always_gravatar, false ); ?>
            >
            <span><?php _e( 'Always use gravatar', 'fictioneer' ) ?></span>
          </label>
        </div>
        <div>
          <label for="fictioneer_disable_avatar" class="checkbox-group">
            <input
              name="fictioneer_disable_avatar"
              type="checkbox"
              id="fictioneer_disable_avatar"
              value="1"
              <?php echo checked( 1, $disable_avatar, false ); ?>
            >
            <span><?php _e( 'Disable avatar', 'fictioneer' ) ?></span>
          </label>
        </div>
        <?php if ( get_option( 'fictioneer_enable_custom_badges' ) ) : ?>
          <div class="profile__input-wrapper profile__input-wrapper--checkbox">
            <label for="fictioneer_hide_badge" class="checkbox-group">
              <input
                name="fictioneer_hide_badge"
                type="checkbox"
                id="fictioneer_hide_badge"
                value="1"
                <?php echo checked( 1, $hide_badge, false ); ?>
              >
              <span><?php _e( 'Hide badge', 'fictioneer' ) ?></span>
            </label>
          </div>
          <?php if ( ! empty( get_the_author_meta( 'fictioneer_badge_override', $profile_user->ID ) ) ) : ?>
            <div class="profile__input-wrapper profile__input-wrapper--checkbox">
              <label for="fictioneer_disable_badge_override" class="checkbox-group">
                <input
                  name="fictioneer_disable_badge_override"
                  type="checkbox"
                  id="fictioneer_disable_badge_override"
                  value="1"
                  <?php echo checked( 1, $disable_override_badge, false ); ?>
                >
                <span><?php _e( 'Override assigned badge', 'fictioneer' ) ?></span>
              </label>
            </div>
          <?php endif; ?>
        <?php endif; ?>
        <?php if ( get_option( 'fictioneer_enable_comment_notifications' ) ) : ?>
          <div class="profile__input-wrapper profile__input-wrapper--checkbox">
            <label for="fictioneer_comment_reply_notifications" class="checkbox-group">
              <input
                name="fictioneer_comment_reply_notifications"
                type="checkbox"
                id="fictioneer_comment_reply_notifications"
                value="1"
                <?php echo checked( 1, $reply_notifications, false ); ?>
              >
              <span><?php _e( 'Always subscribe to comment reply notifications', 'fictioneer' ) ?></span>
            </label>
          </div>
        <?php endif; ?>
      </fieldset>
    </td>
  </tr>
  <?php // <--- End HTML
}
add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_fields_flags', 6 );

// =============================================================================
// SHOW OAUTH
// =============================================================================

/**
 * Render OAuth connections in admin profile
 *
 * @since Fictioneer 5.2.5
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

function fictioneer_admin_profile_fields_oauth( $profile_user ) {
  // Setup
  $oauth_providers = array(
    ['discord', 'Discord'],
    ['twitch', 'Twitch'],
    ['google', 'Google'],
    ['patreon', 'Patreon']
  );
  $sender_is_owner = $profile_user->ID === get_current_user_id();
  $confirmation_string = _x( 'delete', 'Prompt confirm deletion string.', 'fictioneer' );

  // Guard (only profile owner)
  if ( ! $sender_is_owner ) return;

  // Start HTML ---> ?>
  <tr class="user-fictioneer-oauth-wrap">
    <th><?php _e( 'OAuth 2.0 Connections', 'fictioneer' ) ?></th>
    <td>
      <p style="margin: 0.35em 0 1em !important;">
        <?php _e( 'Your profile can be linked to one or more external accounts, such as Discord or Google. You may add or remove these accounts at your own volition, but be aware that removing all accounts will lock you out with no means of access.', 'fictioneer' ); ?>
      </p>
      <fieldset>
        <?php foreach ( $oauth_providers as $provider ) : ?>

          <?php if (
            get_option( "fictioneer_{$provider[0]}_client_id" ) &&
            get_option( "fictioneer_{$provider[0]}_client_secret" ) ) :
          ?>

            <?php if ( ! get_the_author_meta( "fictioneer_{$provider[0]}_id_hash", $profile_user->ID ) ) : ?>
            <?php endif; ?>

          <?php endif; ?>

        <?php endforeach; ?>

        <?php
        foreach ( $oauth_providers as $provider ) {
          $client_id = get_option( "fictioneer_{$provider[0]}_client_id" ) ?: null;
          $client_secret = get_option( "fictioneer_{$provider[0]}_client_secret" ) ?: null;
          $id_hash = get_the_author_meta( "fictioneer_{$provider[0]}_id_hash", $profile_user->ID ) ?: null;
          $confirmation_message = sprintf(
            __( 'Are you sure? Note that if you disconnect all accounts, you may no longer be able to log back in once you log out. Enter %s to confirm.', 'fictioneer' ),
            strtoupper( $confirmation_string )
          );

          if ( $client_id && $client_secret ) {
            if ( empty( $id_hash ) ) {
              // Start HTML ---> ?>
              <div class="oauth-connection">
                <?php
                  echo fictioneer_get_oauth_login_link(
                    $provider[0],
                    "<i class='fa-brands fa-{$provider[0]}'></i> <span>{$provider[1]}</span>",
                    false,
                    true,
                    '_disconnected button',
                    0,
                    get_edit_profile_url( $profile_user->ID )
                  )
                ?>
              </div>
              <?php // <--- End HTML
            } else {
              $unset_url = add_query_arg(
                array(
                  'profile_user_id' => $profile_user->ID,
                  'channel' => $provider[0]
                ),
                wp_nonce_url(
                  admin_url( 'admin-post.php?action=admin_profile_unset_oauth' ),
                  "admin_oauth_unset_{$provider[0]}",
                  'fictioneer_nonce'
                )
              );
              // Start HTML ---> ?>
                <div id="oauth-<?php echo $provider[0]; ?>" class="oauth-connection _<?php echo $provider[0]; ?> _connected">
                  <a
                    href="<?php echo $unset_url; ?>"
                    id="oauth-disconnect-<?php echo $provider[0]; ?>"
                    class="button confirm-dialog"
                    data-dialog-message="<?php echo esc_attr( $confirmation_message ); ?>"
                    data-dialog-confirm="<?php echo esc_attr( $confirmation_string ); ?>"
                  >
                    <span><?php _e( 'Disconnect', 'fictioneer' ); ?></span>
                    <i class="fa-brands fa-<?php echo $provider[0]; ?>"></i>
                    <span><?php echo $provider[1]; ?></span>
                  </a>
                </div>
              <?php // <--- End HTML
            }
          }
        }
      ?></fieldset>
    </td>
  </tr>
  <?php // <--- End HTML
}

if ( get_option( 'fictioneer_enable_oauth' ) ) {
  add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_fields_oauth', 7 );
}

// =============================================================================
// SHOW DATA NODES
// =============================================================================

/**
 * Render data nodes in admin profile
 *
 * @since Fictioneer 5.2.5
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

function fictioneer_admin_profile_fields_data_nodes( $profile_user ) {
  // Setup
  $success = $_GET['success'] ?? null;
  $comments_count = get_comments( array( 'user_id' => $profile_user->ID, 'count' => true ) );
  $checkmarks = fictioneer_load_checkmarks( $profile_user );
  $checkmarks_count = count( $checkmarks['data'] );
  $checkmarks_chapters_count = fictioneer_count_chapter_checkmarks( $checkmarks );
  $follows = fictioneer_load_follows( $profile_user );
  $follows_count = count( $follows['data'] );
  $reminders = fictioneer_load_reminders( $profile_user );
  $reminders_count = count( $reminders['data'] );
  $bookmarks = get_user_meta( $profile_user->ID, 'fictioneer_bookmarks', true ) ?: null;
  $sender_is_owner = $profile_user->ID === get_current_user_id();
  $confirmation_string = _x( 'delete', 'Prompt confirm deletion string.', 'fictioneer' );
  $notification_validator = get_user_meta( $profile_user->ID, 'fictioneer_comment_reply_validator', true ) ?: null;
  $comment_subscriptions_count = 0;
  $nodes = array(
    ['comments', '<i class="fa-solid fa-message"></i>', $comments_count]
  );

  if ( ! empty( $notification_validator ) ) {
    $comment_subscriptions_count = get_comments(
      array(
        'user_id' => $profile_user->ID,
        'meta_key' => 'fictioneer_send_notifications',
        'meta_value' => $notification_validator,
        'count' => true
      )
    );
  }

  // Clear local bookmarks
  if ( $success && $success === 'admin-profile-cleared-data-node-bookmarks' ) {
    echo "<script>localStorage.removeItem('fcnChapterBookmarks');</script>";
  }

  // Comment subscriptions?
  if ( get_option( 'fictioneer_enable_comment_notifications' ) && $comment_subscriptions_count > 0 ) {
    $nodes[] = ['comment-subscriptions','<i class="fa-solid fa-envelope"></i>', $comment_subscriptions_count];
  }

  // Follows?
  if ( get_option( 'fictioneer_enable_follows' ) && $follows_count > 0 ) {
    $nodes[] = ['follows', '<i class="fa-solid fa-star"></i>', $follows_count];
  }

  // Reminders?
  if ( get_option( 'fictioneer_enable_reminders' ) && $reminders_count > 0 ) {
    $nodes[] = ['reminders', '<i class="fa-solid fa-clock"></i>', $reminders_count];
  }

  // Checkmarks?
  if ( get_option( 'fictioneer_enable_checkmarks' ) && $checkmarks_count > 0 ) {
    $nodes[] = ['checkmarks', '<i class="fa-solid fa-circle-check"></i>', "{$checkmarks_count}|{$checkmarks_chapters_count}"];
  }

  // Bookmarks?
  if ( get_option( 'fictioneer_enable_bookmarks' ) && ! empty( $bookmarks ) && $bookmarks != '{}' ) {
    $nodes[] = ['bookmarks', '<i class="fa-solid fa-bookmark"></i>', 0];
  }

  // Guard (only profile owner)
  if ( ! $sender_is_owner ) return;

  // --- Start HTML ---> ?>
  <tr class="user-fictioneer-data-wrap">
    <th><?php _e( 'Data', 'fictioneer' ) ?></th>
    <td>
      <p style="margin: 0.35em 0 1em !important;">
        <?php _e( 'The following items represent data nodes stored in your account. Anything submitted by yourself, such as comments. You can clear these nodes here, but be aware that this is irreversible.', 'fictioneer' ); ?>
      </p>
      <fieldset>
        <?php foreach ( $nodes as $node ) : ?>
          <?php
            $clear_url = add_query_arg(
              array(
                'profile_user_id' => $profile_user->ID,
                'node' => $node[0]
              ),
              wp_nonce_url(
                admin_url( 'admin-post.php?action=admin_profile_clear_data_node' ),
                "admin_clear_data_node_{$node[0]}",
                'fictioneer_nonce'
              )
            );

            $confirmation_message = sprintf(
              __( 'Are you sure you want to clear your %s? This action is irreversible. Enter %s to confirm.', 'fictioneer' ),
              str_replace( '-', ' ', $node[0] ),
              strtoupper( $confirmation_string )
            );
          ?>
          <div class="data-node">
            <a
              href="<?php echo esc_url( $clear_url ); ?>"
              id="data-node-clear-<?php echo $node[0]; ?>"
              class="button confirm-dialog"
              data-dialog-message="<?php echo esc_attr( $confirmation_message ); ?>"
              data-dialog-confirm="<?php echo esc_attr( $confirmation_string ); ?>"
            >
              <?php echo $node[1]; ?>
              <span><?php
                if ( empty( $node[2] ) ) {
                  printf(
                    __( 'Clear %s', 'fictioneer' ),
                    ucwords( str_replace( '-', ' ', $node[0] ) )
                  );
                } else {
                  printf(
                    __( 'Clear %s (%s)', 'fictioneer' ),
                    ucwords( str_replace( '-', ' ', $node[0] ) ),
                    $node[2]
                  );
                }
              ?></span>
            </a>
          </div>
        <?php endforeach; ?>
      </fieldset>
    </td>
  </tr>
  <?php // <--- End HTML
}
add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_fields_data_nodes', 8 );

// =============================================================================
// SHOW MODERATION SECTION
// =============================================================================

/**
 * Adds HTML for the moderation section to the wp-admin user profile
 *
 * @since Fictioneer 5.0
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

if ( ! function_exists( 'fictioneer_admin_profile_moderation' ) ) {
  function fictioneer_admin_profile_moderation( $profile_user ) {
    // Setup
    $editing_user_is_admin = fictioneer_is_admin( get_current_user_id() );
    $editing_user_is_moderator = fictioneer_is_moderator( get_current_user_id() );

    // Abort conditions...
    if ( ! $editing_user_is_admin && ! $editing_user_is_moderator ) return;

    // Start HTML ---> ?>
    <tr class="user-moderation-flags-wrap">
      <th><?php _e( 'Moderation Flags', 'fictioneer' ) ?></th>
      <td>
        <fieldset>
          <div>
            <label for="fictioneer_admin_disable_avatar" class="checkbox-group">
              <input name="fictioneer_admin_disable_avatar" type="checkbox" id="fictioneer_admin_disable_avatar" <?php echo checked( 1, get_the_author_meta( 'fictioneer_admin_disable_avatar', $profile_user->ID ), false ); ?> value="1">
              <span><?php _e( 'Disable user avatar', 'fictioneer' ) ?></span>
            </label>
          </div>
          <div>
            <label for="fictioneer_admin_disable_reporting" class="checkbox-group">
              <input name="fictioneer_admin_disable_reporting" type="checkbox" id="fictioneer_admin_disable_reporting" <?php echo checked( 1, get_the_author_meta( 'fictioneer_admin_disable_reporting', $profile_user->ID ), false ); ?> value="1">
              <span><?php _e( 'Disable reporting capability', 'fictioneer' ) ?></span>
            </label>
          </div>
          <div>
            <label for="fictioneer_admin_disable_renaming" class="checkbox-group">
              <input name="fictioneer_admin_disable_renaming" type="checkbox" id="fictioneer_admin_disable_renaming" <?php echo checked( 1, get_the_author_meta( 'fictioneer_admin_disable_renaming', $profile_user->ID ), false ); ?> value="1">
              <span><?php _e( 'Disable renaming capability', 'fictioneer' ) ?></span>
            </label>
          </div>
          <div>
            <label for="fictioneer_admin_disable_commenting" class="checkbox-group">
              <input name="fictioneer_admin_disable_commenting" type="checkbox" id="fictioneer_admin_disable_commenting" <?php echo checked( 1, get_the_author_meta( 'fictioneer_admin_disable_commenting', $profile_user->ID ), false ); ?> value="1">
              <span><?php _e( 'Disable commenting capability', 'fictioneer' ) ?></span>
            </label>
          </div>
          <div>
            <label for="fictioneer_admin_disable_editing" class="checkbox-group">
              <input name="fictioneer_admin_disable_editing" type="checkbox" id="fictioneer_admin_disable_editing" <?php echo checked( 1, get_the_author_meta( 'fictioneer_admin_disable_editing', $profile_user->ID ), false ); ?> value="1">
              <span><?php _e( 'Disable comment editing capability', 'fictioneer' ) ?></span>
            </label>
          </div>
          <div>
            <label for="fictioneer_admin_disable_comment_notifications" class="checkbox-group">
              <input name="fictioneer_admin_disable_comment_notifications" type="checkbox" id="fictioneer_admin_disable_comment_notifications" <?php echo checked( 1, get_the_author_meta( 'fictioneer_admin_disable_comment_notifications', $profile_user->ID ), false ); ?> value="1">
              <span><?php _e( 'Disable comment reply notifications', 'fictioneer' ) ?></span>
            </label>
          </div>
          <div>
            <label for="fictioneer_admin_always_moderate_comments" class="checkbox-group">
              <input name="fictioneer_admin_always_moderate_comments" type="checkbox" id="fictioneer_admin_always_moderate_comments" <?php echo checked( 1, get_the_author_meta( 'fictioneer_admin_always_moderate_comments', $profile_user->ID ), false ); ?> value="1">
              <span><?php _e( 'Always hold comments for moderation', 'fictioneer' ) ?></span>
            </label>
          </div>
        </fieldset>
      </td>
    </tr>
    <tr class="user-moderation-message-wrap">
      <th><label for="fictioneer_admin_moderation_message"><?php _e( 'Moderation Message', 'fictioneer' ) ?></label></th>
      <td>
        <textarea name="fictioneer_admin_moderation_message" id="fictioneer_admin_moderation_message" rows="8" cols="30"><?php echo esc_attr( get_the_author_meta( 'fictioneer_admin_moderation_message', $profile_user->ID ) ); ?></textarea>
        <p class="description"><?php _e( 'Custom message in the user profile, which may be a nice thing as well.', 'fictioneer' ) ?></p>
      </td>
    </tr>
    <?php // <--- End HTML
  }
}
add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_moderation', 10 );

// =============================================================================
// SHOW AUTHOR SECTION
// =============================================================================

/**
 * Adds HTML for the author section to the wp-admin user profile
 *
 * @since Fictioneer 5.0
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

if ( ! function_exists( 'fictioneer_admin_profile_author' ) ) {
  function fictioneer_admin_profile_author( $profile_user ) {
    // Setup
    $is_owner = $profile_user->ID === get_current_user_id();
    $profile_user_is_author = fictioneer_is_author( $profile_user->ID );
    $editing_user_is_admin = fictioneer_is_admin( get_current_user_id() );

    // Abort conditions...
    if ( ! $profile_user_is_author ) return;
    if ( ! $is_owner && ! $editing_user_is_admin ) return;

    // Has pages?
    $profile_user_has_pages = get_pages(
      array(
        'authors' => $profile_user->ID,
        'number' => 1
      )
    );

    // Start HTML ---> ?>
    <tr class="user-author-page-wrap">
      <th><label for="fictioneer_author_page"><?php _e( 'Author Page', 'fictioneer' ) ?></label></th>
      <td>
        <?php if ( $profile_user_has_pages ) : ?>
          <?php
            wp_dropdown_pages(
              array(
                'name' => 'fictioneer_author_page',
                'id' => 'fictioneer_author_page',
                'option_none_value' => __( 'None', 'fictioneer' ),
                'show_option_no_change' => __( 'None', 'fictioneer' ),
                'selected' => get_the_author_meta( 'fictioneer_author_page', $profile_user->ID ),
                'authors' => $profile_user->ID
              )
            );
          ?>
        <?php else : ?>
          <select disabled>
            <option value="-1"><?php _e( 'You have no published pages yet.', 'fictioneer' ); ?></option>
          </select>
        <?php endif; ?>
        <p class="description"><?php _e( 'Rendered inside your public author profile. This will override your biographical info.', 'fictioneer' ) ?></p>
      </td>
    </tr>
    <tr class="user-support-message-wrap">
      <th><label for="fictioneer_support_message"><?php _e( 'Support Message', 'fictioneer' ) ?></label></th>
      <td>
        <input name="fictioneer_support_message" type="text" id="fictioneer_support_message" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_support_message', $profile_user->ID ) ); ?>" class="regular-text">
        <p class="description"><?php _e( 'Rendered at the bottom of your chapters. This will override "You can support the author on".', 'fictioneer' ) ?></p>
      </td>
    </tr>
    <tr class="user-support-links-wrap">
      <th><?php _e( 'Support Links', 'fictioneer' ) ?></th>
      <td>
        <fieldset>
          <input name="fictioneer_user_patreon_link" type="text" id="fictioneer_user_patreon_link" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_user_patreon_link', $profile_user->ID ) ); ?>" class="regular-text">
          <p class="description"><?php _e( 'Patreon link', 'fictioneer' ) ?></p>
          <br>
          <input name="fictioneer_user_kofi_link" type="text" id="fictioneer_user_kofi_link" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_user_kofi_link', $profile_user->ID ) ); ?>" class="regular-text">
          <p class="description"><?php _e( 'Ko-Fi link', 'fictioneer' ) ?></p>
          <br>
          <input name="fictioneer_user_subscribestar_link" type="text" id="fictioneer_user_subscribestar_link" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_user_subscribestar_link', $profile_user->ID ) ); ?>" class="regular-text">
          <p class="description"><?php _e( 'SubscribeStar link', 'fictioneer' ) ?></p>
          <br>
          <input name="fictioneer_user_paypal_link" type="text" id="fictioneer_user_paypal_link" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_user_paypal_link', $profile_user->ID ) ); ?>" class="regular-text">
          <p class="description"><?php _e( 'PayPal link', 'fictioneer' ) ?></p>
          <br>
          <input name="fictioneer_user_donation_link" type="text" id="fictioneer_user_donation_link" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_user_donation_link', $profile_user->ID ) ); ?>" class="regular-text">
          <p class="description"><?php _e( 'Generic donation link', 'fictioneer' ) ?></p>
        </fieldset>
      </td>
    </tr>
    <?php // <--- End HTML
  }
}
add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_author', 20 );

// =============================================================================
// SHOW OAUTH ID HASHES SECTION
// =============================================================================

/**
 * Adds HTML for the OAuth section to the wp-admin user profile
 *
 * @since Fictioneer 5.0
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

if ( ! function_exists( 'fictioneer_admin_profile_oauth' ) ) {
  function fictioneer_admin_profile_oauth( $profile_user ) {
    // Setup
    $editing_user_is_admin = fictioneer_is_admin( get_current_user_id() );

    // Abort conditions...
    if ( ! $editing_user_is_admin || ! get_option( 'fictioneer_enable_oauth' ) ) return;

    // Start HTML ---> ?>
    <tr class="user-oauth-connections-wrap">
      <th><?php _e( 'Account Bindings', 'fictioneer' ) ?></th>
      <td>
        <fieldset>
          <input name="fictioneer_discord_id_hash" type="text" id="fictioneer_discord_id_hash" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_discord_id_hash', $profile_user->ID ) ); ?>" class="regular-text">
          <p class="description"><?php _e( 'Discord ID Hash', 'fictioneer' ) ?></p>
          <br>
          <input name="fictioneer_twitch_id_hash" type="text" id="fictioneer_twitch_id_hash" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_twitch_id_hash', $profile_user->ID ) ); ?>" class="regular-text">
          <p class="description"><?php _e( 'Twitch ID Hash', 'fictioneer' ) ?></p>
          <br>
          <input name="fictioneer_google_id_hash" type="text" id="fictioneer_google_id_hash" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_google_id_hash', $profile_user->ID ) ); ?>" class="regular-text">
          <p class="description"><?php _e( 'Google ID Hash', 'fictioneer' ) ?></p>
          <br>
          <input name="fictioneer_patreon_id_hash" type="text" id="fictioneer_patreon_id_hash" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_patreon_id_hash', $profile_user->ID ) ); ?>" class="regular-text">
          <p class="description"><?php _e( 'Patreon ID Hash', 'fictioneer' ) ?></p>
        </fieldset>
      </td>
    </tr>
    <?php // <--- End HTML
  }
}

if ( FICTIONEER_SHOW_OAUTH_HASHES ) {
  add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_oauth', 30 );
}

// =============================================================================
// SHOW BADGE SECTION
// =============================================================================

/**
 * Adds HTML for the badge section to the wp-admin user profile
 *
 * @since Fictioneer 5.0
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

if ( ! function_exists( 'fictioneer_admin_profile_badge' ) ) {
  function fictioneer_admin_profile_badge( $profile_user ) {
    // Setup
    $editing_user_is_admin = fictioneer_is_admin( get_current_user_id() );

    // Abort conditions...
    if ( ! $editing_user_is_admin ) return;

    // Start HTML ---> ?>
    <tr class="user-badge-override-wrap">
      <th><label for="fictioneer_badge_override"><?php _e( 'Badge Override', 'fictioneer' ) ?></label></th>
      <td>
        <input name="fictioneer_badge_override" type="text" id="fictioneer_badge_override" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_badge_override', $profile_user->ID ) ); ?>" class="regular-text">
        <p class="description"><?php _e( 'Override the user’s badge.', 'fictioneer' ) ?></p>
      </td>
    </tr>
    <?php // <--- End HTML
  }
}
add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_badge', 40 );

// =============================================================================
// SHOW EXTERNAL AVATAR SECTION
// =============================================================================

/**
 * Adds HTML for the external avatar section to the wp-admin user profile
 *
 * @since Fictioneer 5.0
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

if ( ! function_exists( 'fictioneer_admin_profile_external_avatar' ) ) {
  function fictioneer_admin_profile_external_avatar( $profile_user ) {
    // Setup
    $editing_user_is_admin = fictioneer_is_admin( get_current_user_id() );

    // Abort conditions...
    if ( ! $editing_user_is_admin ) return;

    // Start HTML ---> ?>
    <tr class="user-external-avatar-wrap">
      <th><label for="fictioneer_external_avatar_url"><?php _e( 'External Avatar URL', 'fictioneer' ) ?></label></th>
      <td>
        <input name="fictioneer_external_avatar_url" type="text" id="fictioneer_external_avatar_url" value="<?php echo esc_attr( get_the_author_meta( 'fictioneer_external_avatar_url', $profile_user->ID ) ); ?>" class="regular-text">
        <p class="description"><?php _e( 'There is no guarantee this URL remains valid!', 'fictioneer' ) ?></p>
      </td>
    </tr>
    <?php // <--- End HTML
  }
}
add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_external_avatar', 50 );

// =============================================================================
// SHOW PATREON TIERS
// =============================================================================

/**
 * Adds HTML for the Patreon tiers section to the wp-admin user profile
 *
 * DISABLED!
 *
 * @since Fictioneer 5.0
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

if ( ! function_exists( 'fictioneer_admin_profile_patreon_tiers' ) ) {
  function fictioneer_admin_profile_patreon_tiers( $profile_user ) {
    // Setup
    $editing_user_is_admin = fictioneer_is_admin( get_current_user_id() );

    // Abort conditions...
    if ( ! $editing_user_is_admin ) return;

    // Start HTML ---> ?>
    <tr class="user-patreon-tiers-wrap">
      <th><label for="fictioneer_patreon_tiers"><?php _e( 'Patreon Tiers', 'fictioneer' ) ?></label></th>
      <td>
        <input name="fictioneer_patreon_tiers" type="text" id="fictioneer_patreon_tiers" value="<?php echo esc_attr( json_encode( get_the_author_meta( 'fictioneer_patreon_tiers', $profile_user->ID ) ) ); ?>" class="regular-text" readonly>
        <p class="description"><?php _e( 'Patreon tiers for the linked Patreon client. Valid for two weeks after last login.', 'fictioneer' ) ?></p>
      </td>
    </tr>
    <?php // <--- End HTML
  }
}
// add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_patreon_tiers', 60 );

// =============================================================================
// SHOW BOOKMARKS SECTION
// =============================================================================

/**
 * Adds HTML for the bookmarks section to the wp-admin user profile
 *
 * DISABLED!
 *
 * @since Fictioneer 5.0
 *
 * @param WP_User $profile_user The profile user object. Not necessarily the one
 *                              currently editing the profile!
 */

if ( ! function_exists( 'fictioneer_admin_profile_bookmarks' ) ) {
  function fictioneer_admin_profile_bookmarks( $profile_user ) {
    // Setup
    $editing_user_is_admin = fictioneer_is_admin( get_current_user_id() );

    // Abort conditions...
    if ( ! $editing_user_is_admin ) return;

    // Start HTML ---> ?>
    <tr class="user-bookmarks-wrap">
      <th><label for="user_bookmarks"><?php _e( 'Bookmarks JSON', 'fictioneer' ) ?></label></th>
      <td>
        <textarea name="user_bookmarks" id="user_bookmarks" rows="12" cols="30" style="font-family: monospace; font-size: 12px; word-break: break-all;" disabled><?php echo esc_attr( get_the_author_meta( 'fictioneer_bookmarks', $profile_user->ID ) ); ?></textarea>
      </td>
    </tr>
    <?php // <--- End HTML
  }
}
// add_action( 'fictioneer_admin_user_sections', 'fictioneer_admin_profile_bookmarks', 70 );

?>

<?php
/**
 * Partial: Phrases Settings
 *
 * @package WordPress
 * @subpackage Fictioneer
 * @since 4.7
 */
?>

<div class="fictioneer-ui fictioneer-settings">

	<?php fictioneer_settings_header( 'phrases' ); ?>

	<div class="fictioneer-settings__content">

    <div class="tab-content">
      <form method="post" action="options.php" class="form">
        <?php settings_fields( 'fictioneer-settings-phrases-group' ); ?>
        <?php do_settings_sections( 'fictioneer-settings-phrases-group' ); ?>

        <div class="columns-layout two-columns">

          <div class="card">
    				<div class="card-wrapper">
    					<h3 class="card-header"><?php _e( 'Maintenance Note', 'fictioneer' ) ?></h3>
    					<div class="card-content">
    						<div class="overflow-horizontal">
                  <div class="textarea row">
                    <?php
                      $default = esc_html( __( 'Website under planned maintenance. Please check back later.', 'fictioneer' ) );
                    ?>
                    <textarea name="fictioneer_phrase_maintenance" id="fictioneer_phrase_maintenance" rows="4" placeholder="<?php echo $default; ?>"><?php echo esc_attr( get_option( 'fictioneer_phrase_maintenance' ) ); ?></textarea>
                    <p class="sub-label"><?php _e( 'HTML allowed.', 'fictioneer' ) ?></p>
                  </div>
                  <div class="code row">
                    <code><?php echo $default; ?></code>
                  </div>
    						</div>
    					</div>
    				</div>
    			</div>

          <div class="card">
    				<div class="card-wrapper">
    					<h3 class="card-header"><?php _e( 'Login Modal', 'fictioneer' ) ?></h3>
    					<div class="card-content">
    						<div class="overflow-horizontal">
                  <div class="textarea row">
                    <?php
                      $default = esc_html( __( '<p>Log in with a social media account to set up a profile. You can change your nickname later.</p>', 'fictioneer' ) );
                    ?>
                    <textarea name="fictioneer_phrase_login_modal" id="fictioneer_phrase_login_modal" rows="4" placeholder="<?php echo $default; ?>"><?php echo esc_attr( get_option( 'fictioneer_phrase_login_modal' ) ); ?></textarea>
                    <p class="sub-label"><?php _e( 'HTML allowed. <code>[[privacy_policy_url]]</code>', 'fictioneer' ) ?></p>
                  </div>
                  <div class="code row">
                    <code><?php echo $default; ?></code>
                  </div>
    						</div>
    					</div>
    				</div>
    			</div>

          <div class="card">
    				<div class="card-wrapper">
    					<h3 class="card-header"><?php _e( 'Cookie Consent Banner', 'fictioneer' ) ?></h3>
    					<div class="card-content">
    						<div class="overflow-horizontal">
                  <div class="textarea row">
                    <?php
                      $default = esc_html( __( 'We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. Some features are not available without, but you can limit the site to strictly necessary cookies only. See <a href="[[privacy_policy_url]]" target="_blank" tabindex="1">Privacy Policy</a>.', 'fictioneer' ) );
                    ?>
                    <textarea name="fictioneer_phrase_cookie_consent_banner" id="fictioneer_phrase_cookie_consent_banner" rows="4" placeholder="<?php echo $default; ?>"><?php echo esc_attr( get_option( 'fictioneer_phrase_cookie_consent_banner' ) ); ?></textarea>
                    <p class="sub-label"><?php _e( 'HTML allowed. <code>[[privacy_policy_url]]</code>', 'fictioneer' ) ?></p>
                  </div>
                  <div class="code row">
                    <code><?php echo $default; ?></code>
                  </div>
    						</div>
    					</div>
    				</div>
    			</div>

          <div class="card">
    				<div class="card-wrapper">
    					<h3 class="card-header"><?php _e( 'Comment Reply Notification Email', 'fictioneer' ) ?></h3>
    					<div class="card-content">
    						<div class="overflow-horizontal">
                  <div class="textarea row">
                    <?php
                      $default = esc_html( __( 'Hello [[comment_name]],<br><br>you have a new reply to your comment in <a href="[[post_url]]">[[post_title]]</a>.<br><br><br><strong>[[reply_name]] replied on [[reply_date]]:</strong><br><br><fieldset>[[reply_content]]</fieldset><br><br><a href="[[unsubscribe_url]]">Unsubscribe from this comment.</a>', 'fictioneer' ) );
                    ?>
                    <textarea name="fictioneer_phrase_comment_reply_notification" id="fictioneer_phrase_comment_reply_notification" rows="8" placeholder="<?php echo $default; ?>"><?php echo esc_attr( get_option( 'fictioneer_phrase_comment_reply_notification' ) ); ?></textarea>
                    <p class="sub-label"><?php _e( 'HTML allowed, but note that many email clients do not support modern markup or styles. Better stick to 10+ years old HTML and very simple inline CSS. Also always include an unsubscribe link. <code>[[post_title]]</code> <code>[[post_url]]</code> <code>[[comment_id]]</code> <code>[[comment_name]]</code> <code>[[comment_excerpt]]</code> <code>[[reply_id]]</code> <code>[[reply_name]]</code> <code>[[reply_date]]</code> <code>[[reply_excerpt]]</code> <code>[[reply_content]]</code> <code>[[site_title]]</code> <code>[[site_url]]</code> <code>[[unsubscribe_url]]</code>', 'fictioneer' ) ?></p>
                  </div>
                  <div class="code row">
                    <code><?php echo $default; ?></code>
                  </div>
    						</div>
    					</div>
    				</div>
    			</div>

          <?php do_action( 'fictioneer_admin_settings_phrases' ); ?>

        </div>

        <div class="action-row">
          <?php submit_button(); ?>
        </div>

      </form>
    </div>
  </div>
</div>

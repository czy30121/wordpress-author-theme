<?php

// =============================================================================
// GET CARD LIST
// =============================================================================

/**
 * Returns the query and HTML list items for a post type.
 *
 * @since Fictioneer 5.0
 *
 * @param string $type       Either story, chapter, collection, recommendation, or post.
 * @param array  $query_args Optional. Query arguments merged with the defaults.
 * @param string $empty      Optional. What to show as empty result. Defaults to 'No results'.
 * @param array  $card_args  Optional. Card partial arguments merged with the defaults.
 *
 * @return array|boolean The query results ('query') and the cards as list items ('html').
 *                       False for impermissible parameters.
 */

function fictioneer_get_card_list( $type, $query_args = [], $empty = '', $card_args = [] ) {
  // Setup
  $html = '';
  $empty = $empty === '' ? __( 'No results.', 'fictioneer' ) : $empty;
  $posts = false;
  $allowed_types = ['fcn_story', 'fcn_chapter', 'fcn_collection', 'fcn_recommendation', 'post'];
  $post_type = in_array( $type, ['story', 'chapter', 'collection', 'recommendation'] ) ? "fcn_$type" : $type;
  $page = isset( $query_args['paged'] ) ? $query_args['paged'] : 1;
  $is_empty = false;

  // Validations
  if ( ! in_array( $post_type, $allowed_types ) ) return false;

  // Default query arguments
  $the_query_args = array(
    'post_type' => $post_type,
    'post_status' => 'publish',
    'orderby' => 'modified',
    'order' => 'DESC',
    'posts_per_page' => get_option( 'posts_per_page' )
  );

  // Default card arguments
  $the_card_args = array(
    'cache' => fictioneer_caching_active() && ! fictioneer_private_caching_active()
  );

  // Merge with optional arguments
  $the_query_args = array_merge( $the_query_args, $query_args );
  $the_card_args = array_merge( $the_card_args, $card_args );

  // Query (but not if 'post__in' is set and empty)
  if ( ! ( isset( $query_args['post__in'] ) && empty( $the_query_args['post__in'] ) ) ) {
    $posts = new WP_Query( $the_query_args );
  }

  // Buffer HTML output
  ob_start();

  // Loop results
  if ( $posts && $posts->have_posts() ) {
    while ( $posts->have_posts() ) {
      $posts->the_post();
      get_template_part( 'partials/_card-' . str_replace( 'fcn_', '', $post_type ), null, $the_card_args );
    }

    wp_reset_postdata();
  } elseif ( $empty ) {
    $is_empty = true;
    // Start HTML ---> ?>
    <li class="no-results"><?php echo $page > 1 ? __( 'No more results.', 'fictioneer' ) : $empty; ?></li>
    <?php // <--- End HTML
  }

  // Get buffered HTML
  $html = ob_get_clean();
  // $html = preg_replace( '/\s+/', ' ', $html ); // Remove excessive whitespaces

  // Return results
  return ['query' => $posts, 'html' => $html, 'page' => $page, 'empty' => $is_empty];
}

// =============================================================================
// APPEND DATE QUERY
// =============================================================================

if ( ! function_exists( 'fictioneer_append_date_query' ) ) {
  /**
   * Append date query to query arguments
   *
   * @since 5.4.0
   *
   * @param array      $query_args  The query arguments to modify.
   * @param string|int $ago         The time range in days or valid date string. Default 0.
   * @param string     $order       The current order. Default 'desc'.
   * @param string     $orderby     The current orderby. Default 'modified'.
   *
   * @return array The modified query arguments.
   */

  function fictioneer_append_date_query( $query_args, $ago = 0, $order = 'desc', $orderby = 'modified' ) {
    // Ago?
    if ( empty( $ago ) ) {
      $ago = $_GET['ago'] ?? 0;
      $ago = is_numeric( $ago ) ? absint( $ago ) : sanitize_text_field( $ago );
    }

    // Order?
    if ( empty( $order ) ) {
      $order = array_intersect( [strtolower( $_GET['order'] ?? 0 )], ['desc', 'asc'] );
      $order = reset( $order ) ?: 'desc';
    }

    // Orderby?
    if ( empty( $orderby ) ) {
      $orderby = array_intersect( [strtolower( $_GET['orderby'] ?? 0 )], ['modified', 'date', 'title', 'rand'] );
      $orderby = reset( $orderby ) ?: 'modified';
    }

    // Validate ago argument
    if ( ! is_numeric( $ago ) && strtotime( $ago ) === false ) {
      $ago = 0;
    }

    // Build date query...
    if ( is_numeric( $ago ) && $ago > 0 ) {
      // ... for number as days
      $query_args['date_query'] = array(
        array(
          'column' => $orderby === 'modified' ? 'post_modified' : 'post_date',
          'after' => absint( $ago ) . ' days ago',
          'inclusive' => true,
        )
      );
    } elseif ( ! empty( $ago ) ) {
      // ... for valid strtotime() string
      $query_args['date_query'] = array(
        array(
          'column' => $orderby === 'modified' ? 'post_modified' : 'post_date',
          'after' => sanitize_text_field( $ago ),
          'inclusive' => true,
        )
      );
    }

    // Non-date related order?
    if ( isset( $query_args['date_query'] ) && in_array( $orderby, ['title', 'rand'] ) ) {
      // Second condition for modified date
      $modified_arg = $query_args['date_query'][0];
      $modified_arg['column'] = 'post_modified';

      // Include both publish and modified dates
      $query_args['date_query'] = array(
        'relation' => 'OR',
        $query_args['date_query'][0],
        $modified_arg
      );
    }

    // Return (maybe) modified query arguments
    return $query_args;
  }
}

?>

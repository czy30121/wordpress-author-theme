<?php
/**
 * Partial: Showcase
 *
 * This template part renders a showcase of posts and can be called with the
 * [fictioneer_showcase for="post_type" count order orderby author post_ids]
 * shortcode. Posts are displayed as grid with a maximum of three columns,
 * collapsing to one on mobile.
 *
 * @package WordPress
 * @subpackage Fictioneer
 * @since 4.0
 *
 * @internal $args['type']          Post type if the showcase.
 * @internal $args['count']         Maximum number of items. Default 8.
 * @internal $args['order']         Order direction. Default 'DESC'.
 * @internal $args['orderby']       Order argument. Default 'date'.
 * @internal $args['author']        Author provided by the shortcode.
 * @internal $args['post_ids']      Array of post IDs. Default empty.
 * @internal $args['excluded_cats'] Array of category IDs to exclude. Default empty.
 * @internal $args['excluded_tags'] Array of tag IDs to exclude. Default empty.
 * @internal $args['taxonomies']    Array of taxonomy arrays. Default empty.
 * @internal $args['relation']      Relationship between taxonomies.
 * @internal $args['classes']       Additional classes.
 */
?>

<?php

// Prepare query
$query_args = array (
  'post_type' => $args['type'],
  'post_status' => 'publish',
  'post__in' => $args['post_ids'],
  'order' => $args['order'] ?? 'DESC',
  'orderby' => $args['orderby'] ?? 'date',
  'posts_per_page' => $args['count'] ?? 8,
  'update_post_term_cache' => false,
  'no_found_rows' => true
);

// Filter for author?
if ( isset( $args['author'] ) && $args['author'] ) $query_args['author_name'] = $args['author'];

// Taxonomies?
if ( ! empty( $args['taxonomies'] ) ) {
  $query_args['tax_query'] = fictioneer_get_shortcode_tax_query( $args );
}

// Excluded tags?
if ( ! empty( $args['excluded_tags'] ) ) {
  $query_args['tag__not_in'] = $args['excluded_tags'];
}

// Excluded categories?
if ( ! empty( $args['excluded_cats'] ) ) {
  $query_args['category__not_in'] = $args['excluded_cats'];
}

// Apply filters
$query_args = apply_filters( 'fictioneer_filter_shortcode_showcase_query_args', $query_args, $args );

// Query collections
$query = new WP_Query( $query_args );

?>

<?php if ( $query->have_posts() ) : ?>
  <section class="showcase <?php echo implode( ' ', $args['classes'] ); ?>">
    <ul class="showcase__list">
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>
        <li class="showcase__list-item">
          <a class="polygon" href="<?php the_permalink(); ?>">
            <figure>
              <?php
                // Setup
                $list_title = '';
                $story_id = null;
                $landscape_image_id = fictioneer_get_field( 'fictioneer_landscape_image', get_the_ID() );

                // Get list title and story ID (if any)
                switch ( $args['type'] ) {
                  case 'fcn_collection':
                    $list_title = trim( fictioneer_get_field( 'fictioneer_collection_list_title' ) );
                    break;
                  case 'fcn_chapter':
                    $list_title = trim( fictioneer_get_field( 'fictioneer_chapter_list_title' ) );
                    $story_id = fictioneer_get_field( 'fictioneer_chapter_story', get_the_ID() );
                    if ( empty( $landscape_image_id ) ) {
                      $landscape_image_id = fictioneer_get_field( 'fictioneer_landscape_image', $story_id );
                    }
                    break;
                }

                // Prepare title
                $title = empty( $list_title ) ? fictioneer_get_safe_title( $post ) : $list_title;

                // Prepare image arguments
                $image_args = array(
                  'alt' => sprintf( __( '%s Cover', 'fictioneer' ), $title ),
                  'class' => 'no-auto-lightbox showcase__image'
                );

                // Output image or placeholder
                if ( ! empty( $landscape_image_id ) ) {
                  echo wp_get_attachment_image( $landscape_image_id, 'medium', false, $image_args );
                } elseif ( has_post_thumbnail() ) {
                  the_post_thumbnail( 'medium', $image_args );
                } elseif ( $story_id && has_post_thumbnail( $story_id ) ) {
                  echo get_the_post_thumbnail( $story_id, 'medium', $image_args );
                } else {
                  echo '<div class="showcase__image _no-cover"></div>';
                }
              ?>
              <?php if ( ! $args['no_cap'] ) : ?>
                <figcaption><?php echo $title; ?></figcaption>
              <?php endif; ?>
            </figure>
          </a>
        </li>
      <?php endwhile; ?>
    </ul>
  </section>
<?php endif; wp_reset_postdata(); ?>

<?php
/**
 * Template Name: Bookshelf AJAX
 *
 * Page template for rendering all the user's custom lists such as Follows,
 * Reminders, and anything else. You can still add regular content here but
 * the point of that is highly debatable.
 *
 * @package WordPress
 * @subpackage Fictioneer
 * @since 5.0
 */
?>

<?php

// Setup
$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : null;
$order = isset( $_GET['order'] ) ? strtolower( $_GET['order'] ) : 'desc';
$order = in_array( $order, ['desc', 'asc'] ) ? $order : 'desc';
$current_page = get_query_var( 'pg', 1 );
$max_pages = 1;
$tabs = [];

// Follows?
if ( get_option( 'fictioneer_enable_follows' ) ) {
  // Add to tabs
  $tabs['follows'] = array(
    'name' => fcntr( 'follows' ),
    'classes' => [],
    'action' => 'fictioneer_ajax_get_follows_list'
  );
}

// Reminders?
if ( get_option( 'fictioneer_enable_reminders' ) ) {
  // Add to tabs
  $tabs['reminders'] = array(
    'name' => fcntr( 'reminders' ),
    'classes' => [],
    'action' => 'fictioneer_ajax_get_reminders_list'
  );
}

// Checkmarks?
if ( get_option( 'fictioneer_enable_checkmarks' ) ) {
  // Add to tabs
  $tabs['finished'] = array(
    'name' => __( 'Finished', 'fictioneer' ),
    'classes' => [],
    'action' => 'fictioneer_ajax_get_finished_list'
  );
}

// Return home if nothing to display
if ( count( $tabs ) < 1 ) {
  wp_redirect( home_url() );
  exit();
}

// Use first tab if queried tab is not available
if ( ! array_key_exists( $current_tab, $tabs ) ) $current_tab = array_key_first( $tabs );

// Select tab
$tabs[ $current_tab ]['classes'][] = '_current';

?>

<?php get_header(); ?>

<main id="main" class="main singular bookshelf">
  <div class="main-observer"></div>
  <?php do_action( 'fictioneer_main' ); ?>
  <div class="main__background polygon polygon--main background-texture"></div>
  <div class="main__wrapper">
    <?php do_action( 'fictioneer_main_wrapper' ); ?>

    <?php while ( have_posts() ) : the_post(); ?>

      <?php
        // Inner setup
        $title = trim( get_the_title() );
        $title = empty( $title ) ? __( 'Bookshelf', 'fictioneer' ) : $title;
        $this_breadcrumb = [$title, get_the_permalink()];
        $current_url = get_the_permalink();
        $order_link = add_query_arg(
          array(
            'tab' => $current_tab,
            'order' => ['desc' => 'asc', 'asc' => 'desc'][ $order ]
          ),
          $current_url
        ) . '#main';
      ?>

      <article id="singular-<?php the_ID(); ?>" class="singular__article padding-left padding-right padding-top padding-bottom">

        <?php if ( ! empty( $title ) ) : ?>
          <header class="singular__header">
            <h1 class="singular__title"><?php echo $title; ?></h1>
          </header>
        <?php endif; ?>

        <?php if ( get_the_content() ) : ?>
          <section class="singular__content content-section">
            <?php the_content(); ?>
          </section>
        <?php endif; ?>

        <?php if ( count( $tabs ) > 1 ) : ?>
          <section id="tabs" class="bookshelf__tabs tabs-wrapper spacing-top">
            <div class="tabs">
              <?php foreach ( $tabs as $key => $value ) : ?>
                <a href="<?php echo
                  esc_url(
                    add_query_arg(
                      array(
                        'tab' => $key,
                        'order' => $order
                      ),
                      $current_url
                    ) . '#main');
                ?>" class="tabs__item <?php echo implode( ' ', $value['classes'] )?>">
                  <span><?php echo $value['name']; ?></span>
                  <?php if ( $current_tab == $key ) : ?>
                    <span class="item-number">(<i class="fa-solid fa-spinner fa-spin" style="--fa-animation-duration: .8s;"></i>)</span>
                  <?php endif; ?>
                </a>
              <?php endforeach; ?>
            </div>
            <div class="bookshelf__sorting">
              <a class="list-button _order <?php echo $order == 'desc' ? '_on' : '_off'; ?>" href="<?php echo esc_url( $order_link ); ?>">
                <i class="fa-solid fa-arrow-up-short-wide _off"></i>
                <i class="fa-solid fa-arrow-down-wide-short _on"></i>
              </a>
            </div>
          </section>
        <?php endif; ?>

        <section id="list" class="bookshelf__list">
          <ul id="ajax-bookshelf-target" data-tab="<?php echo $current_tab; ?>" data-action="<?php echo $tabs[ $current_tab ]['action']; ?>" data-page="<?php echo get_query_var( 'pg', 1 ); ?>" data-order="<?php echo $order; ?>" class="bookshelf__list card-list">

            <?php for ( $i = 0; $i < 3; $i++ ) : ?>
              <li class="card _skeleton">
                <div class="card__body polygon">
                  <div class="card__header _large"><h3 class="card__title"></h3></div>
                  <div class="card__main _grid _large">
                    <div class="card__image cell-img"></div>
                    <div class="card__content cell-desc truncate _3-4"></div>
                    <div class="card__tag-list cell-tax"><span></span><span></span><span></span></div>
                  </div>
                  <div class="card__footer"><div class="card__left text-overflow-ellipsis"></div></div>
                </div>
              </li>
            <?php endfor; ?>

          </ul>
        </section>

        <footer class="singular__footer"><?php do_action( 'fictioneer_singular_footer' ); ?></footer>

      </article>

    <?php endwhile; ?>
  </div>
</main>

<?php
  // Footer arguments
  $footer_args = array(
    'post_type' => 'page',
    'post_id' => get_the_ID(),
    'breadcrumbs' => array(
      [fcntr( 'frontpage' ), get_home_url()]
    )
  );

  // Add current breadcrumb
  $footer_args['breadcrumbs'][] = $this_breadcrumb;

  // Get footer with breadcrumbs
  get_footer( null, $footer_args );
?>

<?php

$sticky = get_option( 'sticky_posts' );
$args = array(
  'posts_per_page' => 1,
  'post__in'  => $sticky,
  'ignore_sticky_posts' => 1
);

// The Query
$the_query = new WP_Query( $args );

// The Loop

if ( $sticky[0] ) { ?>

    <?php if ( $the_query->have_posts() ) { ?>
      <div class="announcements alert-info">
        <h3>SPLC Announcement</h3>

          <?php
          while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $sticky_excerpt = get_the_excerpt();
            echo '<p><a href="'. get_permalink() .'">' . get_the_title() . '</a></p>';
            echo '<p>'. $sticky_excerpt .'</p>';
          } ?>
      </div>
    <?php } ?>
<?php }

wp_reset_postdata();

?>
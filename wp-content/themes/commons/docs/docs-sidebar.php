<div class="widget widget_em_widget">

  <h4 class="widgettitle">
    Latest Files
  </h4>

  <div class="sidebarList widget-content">

    <?php
    // WP_Query arguments
    $args = array (
      'post_type'      => 'bp_doc',
      'posts_per_page'  => '3',
    );

    // The Query
    $query = new WP_Query( $args );

    // The Loop
    if ( $query->have_posts() ) {
      echo '<ul>';
      while ( $query->have_posts() ) {
        $query->the_post(); ?>
        <li>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
      <?php } ?>
      </ul><a href="<?php bloginfo('url'); ?>/files" class="small">View all files</a>
    <?php } else {
      // no posts found
      echo 'No files created.';
    }

    // Restore original Post Data
    wp_reset_postdata()
    ?>

  </div><!-- /#buddypress -->

</div>
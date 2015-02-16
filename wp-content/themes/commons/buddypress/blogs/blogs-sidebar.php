<div class="widget-accordian-group">

  <div class="widget widget_em_widget">
    <h4 class="widgettitle">Groups<span class="arrow"></span></h4>
    <div class="widget-content">
      <?php if ( bp_has_groups('per_page=0') ) : ?>

          <ul class="small-link-list">
          <?php while ( bp_groups() ) : bp_the_group(); ?>

              <li>
                <a href="<?php bp_group_permalink() ?>"><?php bp_group_name() ?></a>
              </li>

          <?php endwhile; ?>
          </ul>

          <?php do_action( 'bp_after_groups_loop' ) ?>

      <?php else: ?>

          <div id="message" class="info">
              <p><?php _e( 'There were no groups found.', 'buddypress' ) ?></p>
          </div>

      <?php endif; ?>
    </div>
  </div>

  <div class="widget widget_em_widget">
    <h4 class="widgettitle">Categories<span class="arrow"></span></h4>
    <div class="widget-content">
      <ul class="small-link-list">
        <?php
        $args = array(
          'orderby' => 'name',
          'exclude' => '21',
          'parent' => 0
          );
        $categories = get_categories( $args );
        foreach ( $categories as $category ) {
          echo '<li><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></li>';
        }
        ?>
      </ul>
    </div>
  </div>
</div>
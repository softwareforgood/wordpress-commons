<?php
  if(isset($_GET["id"])) { // URL Parameter for create page
    $group_id = $_GET["id"];
  } else if(get_field('this_group')) { // Groups page sidebar
    $field = get_field_object('this_group');
    $group_id = $field['value'];
  } else if(!empty($event_ID)) { // Single Event Page
    $EM_Event = em_get_event($event_ID);
    $group_id = $EM_Event->group_id;
  } else {
    $group_id = bp_get_current_group_id(); // An actual group page
  }


  $group = groups_get_group( array( 'group_id' => $group_id) ); // Everything about this group, for realz
  $visibility = $group->status;

  // If you are a member or the group is public, so sidebar
  if(groups_is_user_member( bp_loggedin_user_id(), $group_id) || $visibility == 'public' ) : ?>

  <div class="widget widget_em_widget">
    <h4 class="widgettitle">
      Group Resources
    </h4>

    <div class="widget-content">

      <?php
      $args = array (
        'post_type'      => 'groups-page',
        'posts_per_page'  => '3',
        'meta_query'         => array(
         array(
          'key' => 'this_group',
          'value' => $group_id,
          )
         ),
        );

      $query = new WP_Query( $args );

      if ( $query->have_posts() ) {
        echo '<ul>';
        while ( $query->have_posts() ) {
         $query->the_post(); ?>
         <li>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
        <?php } ?>
      </ul>

      <?php

      if ( groups_is_user_admin( bp_loggedin_user_id(), $group_id ) || current_user_can('manage_options') ) { ?>
      <p><a href="<?php bloginfo('url'); ?>/create-group-page/?id=<?php echo $group_id; ?>" class="small">Create Page</a></p>
      <?php }

      ?>

      <?php } else {
              // no posts found
        echo 'No Pages created';

        if ( groups_is_user_admin( bp_loggedin_user_id(), $group_id ) || current_user_can('manage_options') ) { ?>
        <p><a href="<?php bloginfo('url'); ?>/create-group-page/?id=<?php echo $group_id; ?>" class="small">Create Page</a></p>
        <?php }
      }

            // Restore original Post Data
      wp_reset_postdata()
      ?>

    </div>
  </div>

  <div class="widget widget_em_widget">
    <h4 class="widgettitle">
      Upcoming Group Events
    </h4>
    <div class="widget-content">
      <ul>
       <?php
       echo do_shortcode('[events_list group='.$group_id.']<li>#_EVENTDATES<ul><li>#_EVENTLINK</li></ul></li>[/events_list]');
       ?>
     </ul>
    </div>
  </div>

  <div class="widget widget_em_widget">
    <h4 class="widgettitle">
      Latest Group Files
    </h4>

    <div class="sidebarList widget-content">

      <?php
      $args = array (
        'post_type'      => 'bp_doc',
        'posts_per_page'  => '3',
        'tax_query'         => array(
         array(
          'taxonomy' => 'bp_docs_associated_item',
          'field' => 'slug',
          'terms' => 'bp_docs_associated_group_'. $group_id
          )
         ),
        );

      $query = new WP_Query( $args );

      if ( $query->have_posts() ) {
        echo '<ul>';
        while ( $query->have_posts() ) {
         $query->the_post(); ?>
         <li>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
        <?php } ?>
      </ul><a href="<?php echo bloginfo('url') . '/groups/'. $group->slug .'/files/';?>" class="small">View all group files</a>
      <?php } else {
                // no posts found
        echo 'No files created';
      }

              // Restore original Post Data
      wp_reset_postdata()
      ?>

    </div>

  </div>

<?php elseif($group_id == '0') : // This event does not belong to a group ?>



<?php else : ?>

  <p><em>Events and files are only available to group members</em></p>

<?php endif; // end visibility check ?>

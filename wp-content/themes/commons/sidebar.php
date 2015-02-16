<div id="sidebar1" class="sidebar threecol first clearfix" role="complementary">

  <?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

  <?php
    $uri = $_SERVER['REQUEST_URI'];
    $title = wp_title('',false);
    if (is_search()) {
      // Search Sidebar
      include ('search-sidebar.php');
    } else if(strpos($uri,'files/') == true) {
      if(bp_is_group_single()) {
        // Files tab in group section
        include ('buddypress/groups/groups-sidebar.php');
      } else {
        // Files section
        include ('docs/docs-sidebar.php');
      }
    } else if(bp_is_group_single() || is_post_type_archive('groups-page') || get_post_type() == 'groups-page' ) {
      // Groups Sidebar
      include ('buddypress/groups/groups-sidebar.php');
    } else if(em_is_event_page()) {
      $event_ID = do_shortcode("[event]#_EVENTID[/event]"); // Need this for event page
      include ('buddypress/groups/groups-sidebar.php');

    } else if(strpos($uri,'locations/') == true) {
      // Location detail, Event detail
      dynamic_sidebar( 'sidebar1' );
    } else if(get_post_type() == 'post') {
      // Blog Sidebar
      include ('buddypress/blogs/blogs-sidebar.php');
    } else if(bp_is_user()) {
      include ('profile-sidebar.php');
    } else {
      dynamic_sidebar( 'sidebar1' );
    }
  ?>

  <?php else : ?>

  <!-- This content shows up if there are no widgets defined in the backend. -->

  <div class="alert alert-help">
    <p><?php _e( 'Please activate some Widgets.', 'bonestheme' );  ?></p>
  </div>

  <?php endif; ?>

</div>

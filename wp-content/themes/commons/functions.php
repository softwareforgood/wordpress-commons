<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
require_once( 'library/admin.php' );

// Enable livereload while working locally
if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
  wp_register_script('livereload', 'http://localhost:35729/livereload.js?snipver=1', null, false, true);
  wp_enqueue_script('livereload');
}

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  //Allow editor style.
  add_editor_style();

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
  require_once( 'library/custom-post-types.php' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

  // launching this stuff after theme setup
  bones_theme_support();

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
  $content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 100 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 150 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* THEME CUSTOMIZE *********************/

/*
  A good tutorial for creating your own Sections, Controls and Settings:
  http://code.tutsplus.com/series/a-guide-to-the-wordpress-theme-customizer--wp-33722

  Good articles on modifying the default options:
  http://natko.com/changing-default-wordpress-theme-customization-api-sections/
  http://code.tutsplus.com/tutorials/digging-into-the-theme-customizer-components--wp-27162

  To do:
  - Create a js for the postmessage transport method
  - Create some sanitize functions to sanitize inputs
  - Create some boilerplate Sections, Controls and Settings
*/

function bones_theme_customizer($wp_customize) {
  // $wp_customize calls go here.
  //
  // Uncomment the below lines to remove the default customize sections

  // $wp_customize->remove_section('title_tagline');
  // $wp_customize->remove_section('colors');
  // $wp_customize->remove_section('background_image');
  // $wp_customize->remove_section('static_front_page');
  // $wp_customize->remove_section('nav');

  // Uncomment the below lines to remove the default controls
  // $wp_customize->remove_control('blogdescription');

  // Uncomment the following to change the default section titles
  // $wp_customize->get_section('colors')->title = __( 'Theme Colors' );
  // $wp_customize->get_section('background_image')->title = __( 'Images' );
}

add_action( 'customize_register', 'bones_theme_customizer' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
  register_sidebar(array(
    'id' => 'sidebar1',
    'name' => __( 'Sidebar 1', 'bonestheme' ),
    'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4><div class="widget-content">',
  ));

  register_sidebar(array(
    'id' => 'public_sidebar',
    'name' => __( 'Public Sidebar', 'bonestheme' ),
    'description' => __( 'Sidebar visible when not logged in.', 'bonestheme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4><div class="widget-content">',
  ));

  /*
  to add more sidebars or widgetized areas, just copy
  and edit the above sidebar code. In order to call
  your new sidebar just use the following code:

  Just change the name to whatever your new
  sidebar's id is, for example:

  register_sidebar(array(
    'id' => 'sidebar2',
    'name' => __( 'Sidebar 2', 'bonestheme' ),
    'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  To call the sidebar in your template, you can just copy
  the sidebar.php file and rename it to your sidebar's name.
  So using the above example, it would be:
  sidebar-sidebar2.php

  */
} // don't remove this bracket!

/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function bones_wpsearch($form) {
  $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
  <label class="screen-reader-text" for="s">' . __( '', 'bonestheme' ) . '</label>
  <input type="text" value="' . get_search_query() . '" name="s" id="s" />
  <input type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
  </form>';
  return $form;
} // don't remove this bracket!

/*********** CUSTOM COMMONS FUNCTIONS **************/

// Enable forum posts in activity stream when search engines are turned off
//add_filter( 'bbp_is_site_public', '__return_true' );

function my_filter_head() {
  remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'my_filter_head');

// Customize the wpadimn bar
function mytheme_admin_bar_render($name) {
  global $wp_admin_bar;

  // Remove default adminbar items
  if ( ! is_admin() ) {
    $wp_admin_bar->remove_menu('bp-login');
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('edit');
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('updates');
    $wp_admin_bar->remove_menu('site-name');
    $wp_admin_bar->remove_menu('user-admin');
    $wp_admin_bar->remove_menu('group-admin');
    $wp_admin_bar->remove_menu('bp-register');
    $wp_admin_bar->add_menu( array(
      'parent' => false,
      'id' => 'logo',
      'title' => 'Logo',
      'href' => home_url(),
      'meta' => false
    ));
    $wp_admin_bar->remove_menu('search');

    // Unauth users only see ability to log in
    if ( ! is_user_logged_in() ) {
      $wp_admin_bar->add_menu( array(
        'parent' => false,
        'id' => 'log-in',
        'title' => 'Login To The Commons',
        'href' => home_url('/wp-login.php'),
        'meta' => false
      ));
    }

    // Logged in users see all pages added to main nav via admin
    if ( is_user_logged_in() ) {

      // Create search form
      $commons_search = '
      <form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
        <label class="screen-reader-text" for="s">' . __( 'Search the Community', 'bonestheme' ) . '</label>
        <input type="text" value="' . get_search_query() . '" name="s" id="s" />
        <input class="btn btn-default" type="submit" id="searchsubmit" value="' . esc_attr__( 'Search' ) .'" />
      </form>';

      // Add Search back to admin bar
      //$wp_admin_bar->add_menu( array( 'id' => 'commons_search', 'title' => __( 'Search the Codex', 'textdomain' ), 'href' => FALSE ) );
      $wp_admin_bar->add_menu( array(
        'parent' => false,
        'id' => 'commons-search',
        'title' => $commons_search,
        'href' => FALSE
        )
      );

      $menu_name = 'main-nav';
      $locations = get_nav_menu_locations();
      $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
      $menuitems = wp_get_nav_menu_items( $menu->term_id, array( 'order' => 'DESC' ) );

      foreach( $menuitems as $item ):
        // get page id from using menu item object id
        $id = get_post_meta( $item->ID, '_menu_item_object_id', true );
        // set up a page object to retrieve page data
        $page = get_page( $id );
        $link = get_page_link( $id );

        $wp_admin_bar->add_menu( array(
          'parent' => false,
          'id' => $page->post_name,
          'title' => $page->post_title,
          'href' => $link,
          'meta' => false
        ));

      endforeach;
    }
  }
}

add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_enqueue_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
}

// Replace WordPress Howdy in WordPress 3.3
function replace_howdy( $wp_admin_bar ) {
  $my_account=$wp_admin_bar->get_node('my-account');
  $newtitle = str_replace( 'Howdy,', '', $my_account->title );
  $wp_admin_bar->add_node( array(
    'id' => 'my-account',
    'title' => $newtitle,
  ));
}
add_filter( 'admin_bar_menu', 'replace_howdy',25 );



// Remove admin bar 'my-account' gravatar:
function ds_add_hide_avatar_filter() {
  add_filter( 'pre_option_show_avatars', '__return_zero' );
}
add_action( 'admin_bar_menu', 'ds_add_hide_avatar_filter', 0 );
function ds_remove_hide_avatar_filter() {
  remove_filter( 'pre_option_show_avatars', '__return_zero' );
}
add_action( 'admin_bar_menu', 'ds_remove_hide_avatar_filter', 10 );
add_action(
  'admin_bar_menu',
  function() {
    add_filter( 'pre_option_show_avatars', '__return_zero' );
  },
  0
);
add_action(
  'admin_bar_menu',
  function() {
    remove_filter( 'pre_option_show_avatars', '__return_zero' );
  },
  10
);



// change url of logo on login page:
function custom_loginlogo_url($url) {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'custom_loginlogo_url' );



// Check "Remember Me" by default
function always_checked_rememberme() {
  echo '<script type="text/javascript">document.getElementById(\'rememberme\').checked = true</script>';
}
add_filter( 'login_footer', 'always_checked_rememberme' );



// Show thumbnail image for blog post in acivity feed:
function icondeposit_bp_activity_entry_meta() {
  if ( bp_get_activity_object_name() == 'blogs' && bp_get_activity_type() == 'new_blog_post' ) {?>
    <?php
      global $wpdb, $post, $bp;
      $theimg = wp_get_attachment_image_src( get_post_thumbnail_id( bp_get_activity_secondary_item_id() ), 'full' );
    ?>
    <?php if ( $theimg[0] !== null) : ?>
      <div class="elastic-avatar wide" style="background-image: url(<?php echo $theimg[0]; ?>);">
        <img src="<?php echo get_template_directory_uri(); ?>/library/images/elastic-avatar-bg-wide.gif" />
      </div>
    <?php endif;
  }
}

// Check if links are fully qualified
function addhttp($url) {
  if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
      $url = "http://" . $url;
  }
  return $url;
}

// Create new pages with ACF 4.X
function my_pre_save_post( $post_id ) {

  // check if this is to be a new post
  if( $post_id != 'new' )
  {
      return $post_id;
  }

  $group_page_title = $_POST['fields']['field_54d92845737a6']; // Field name on Groups Pages

  // Create a new post
  $post = array(
      'post_status'  => 'publish',
      'post_title'  => $group_page_title,
      'post_type'  => 'groups-page',
  );

  // insert the post
  $post_id = wp_insert_post( $post );

  // update $_POST['return']
  $_POST['return'] = add_query_arg( array('post_id' => $post_id), $_POST['return'] );

  // return the new ID
  return $post_id;
}

add_filter('acf/pre_save_post' , 'my_pre_save_post' );

?>

<?php
/* Bones Custom Post Type Example
This page walks you through creating
a custom post type and taxonomies. You
can edit this one or copy the following code
to create another one.

I put this in a separate file so as to
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'bones_flush_rewrite_rules' );

// Flush your rewrite rules
function bones_flush_rewrite_rules() {
  flush_rewrite_rules();
}

function make_some_custom_post_types() {
  register_post_type( 'groups-page', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
    // let's now add all the options for this post type
    array( 'labels' => array(
      'name' => __( 'Groups Pages', 'bonestheme' ), /* This is the Title of the Group */
      'singular_name' => __( 'Group Page', 'bonestheme' ), /* This is the individual type */
      'all_items' => __( 'All Groups Pages', 'bonestheme' ), /* the all items menu item */
      'add_new' => __( 'Add New Group Page', 'bonestheme' ), /* The add new menu item */
      'add_new_item' => __( 'Add New Group Page', 'bonestheme' ), /* Add New Display Title */
      'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
      'edit_item' => __( 'Edit Groups Pages', 'bonestheme' ), /* Edit Display Title */
      'new_item' => __( 'New Group Page', 'bonestheme' ), /* New Display Title */
      'view_item' => __( 'View Group Page', 'bonestheme' ), /* View Display Title */
      'search_items' => __( 'Search Groups Pages', 'bonestheme' ), /* Search Custom Type Title */
      'not_found' =>  __( 'Nothing found in the Database.', 'bonestheme' ), /* This displays if there are no entries yet */
      'not_found_in_trash' => __( 'Nothing found in Trash', 'bonestheme' ), /* This displays if there is nothing in the trash */
      'parent_item_colon' => ''
      ), /* end of arrays */
      'public' => true,
      'publicly_queryable' => true,
      'exclude_from_search' => false,
      'show_ui' => true,
      'query_var' => true,
      'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
      'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
      'rewrite' => array( 'slug' => 'group-page', 'with_front' => false ), /* you can specify its url slug */
      'has_archive' => 'group-pages', /* you can rename the slug here */
      'capability_type' => 'post',
      'hierarchical' => false,
      /* the next one is important, it tells what's enabled in the post editor */
      'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky')
    ) /* end of options */
  ); /* end of register post type */

  /* this adds your post categories to your custom post type */
  register_taxonomy_for_object_type( 'category', 'groups-page' );
  /* this adds your post tags to your custom post type */
  register_taxonomy_for_object_type( 'post_tag', 'groups-page' );
}

add_action( 'init', 'make_some_custom_post_types');

?>
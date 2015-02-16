<?php
// hacks and mods will go here

function remove_public_message_button() {
	remove_filter( 'bp_member_header_actions','bp_send_public_message_button', 20);
}

add_action( 'bp_member_header_actions', 'remove_public_message_button');


function change_avatar_constants() {

	if ( !defined( 'BP_AVATAR_THUMB_WIDTH' ) )
		define( 'BP_AVATAR_THUMB_WIDTH', 80 );

	if ( !defined( 'BP_AVATAR_THUMB_HEIGHT' ) )
		define( 'BP_AVATAR_THUMB_HEIGHT', 80 );

	if ( !defined( 'BP_AVATAR_FULL_WIDTH' ) )
		define( 'BP_AVATAR_FULL_WIDTH', 300 );

	if ( !defined( 'BP_AVATAR_FULL_HEIGHT' ) )
		define( 'BP_AVATAR_FULL_HEIGHT', 300 );

	if ( !defined( 'BP_AVATAR_ORIGINAL_MAX_WIDTH' ) )
		define( 'BP_AVATAR_ORIGINAL_MAX_WIDTH', 450 );

	if ( !defined( 'BP_AVATAR_ORIGINAL_MAX_FILESIZE' ) ) {

		$bp = buddypress();

		if ( !isset( $bp->site_options['fileupload_maxk'] ) ) {
			define( 'BP_AVATAR_ORIGINAL_MAX_FILESIZE', 5120000 ); // 5mb
		} else {
			define( 'BP_AVATAR_ORIGINAL_MAX_FILESIZE', $bp->site_options['fileupload_maxk'] * 1024 );
		}
	}

	if ( !defined( 'BP_AVATAR_DEFAULT' ) )
		define( 'BP_AVATAR_DEFAULT', BP_PLUGIN_URL . 'bp-core/images/mystery-man.jpg' );

	if ( !defined( 'BP_AVATAR_DEFAULT_THUMB' ) )
		define( 'BP_AVATAR_DEFAULT_THUMB', BP_PLUGIN_URL . 'bp-core/images/mystery-man-50.jpg' );

	if ( ! defined( 'BP_SHOW_AVATARS' ) ) {
		define( 'BP_SHOW_AVATARS', bp_get_option( 'show_avatars' ) );
	}
}
add_action( 'bp_init', 'change_avatar_constants', 3 );


function bp_group_avatar_url( $args = '' ) {
	echo bp_get_group_avatar_url( $args );
}
function bp_get_group_avatar_url( $args = '' ) {
	global $bp, $groups_template;

	$defaults = array(
		'type' => 'full',
		'width' => false,
		'height' => false,
		'class' => 'avatar',
		'id' => false,
		'alt' => __( 'Group logo of %s', 'buddypress' )
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	/* Fetch the avatar from the folder, if not provide backwards compat. */
	if ( !$avatar = bp_core_fetch_avatar( array( 'html' => false, 'item_id' => $groups_template->group->id, 'object' => 'group', 'type' => $type, 'avatar_dir' => 'group-avatars', 'alt' => $alt, 'css_id' => $id, 'class' => $class, 'width' => $width, 'height' => $height ) ) )
		$avatar = '<img src="' . esc_attr( $groups_template->group->avatar_thumb ) . '" class="avatar" alt="' . esc_attr( $groups_template->group->name ) . '" />';

		return apply_filters( 'bp_get_group_avatar', $avatar );
}

// Make the Forum the Group Homepage
function redirect_group_home() {
  global $bp;
  $path = esc_url( $_SERVER['REQUEST_URI'] );
  $path = apply_filters( 'bp_uri', $path );

  if (bp_is_group_home() && strpos( $path, $bp->bp_options_nav[$bp->groups->current_group->slug]['home']['slug'] ) === false ) {
    if ($bp->groups->current_group->is_user_member || $bp->groups->current_group->status == 'public') {
      if($bp->groups->current_group->enable_forum == '0') {
      	bp_core_redirect( $path . 'members/' );
      } else {
      	bp_core_redirect( $path . 'forum/' );
      }
    }
  }
}

// Remove the activity tab from the group pages
function move_group_activity_tab() {
  global $bp;
  if (isset($bp->groups->current_group->slug) && $bp->groups->current_group->slug == $bp->current_item) {
    unset($bp->bp_options_nav[$bp->groups->current_group->slug]['home']);
    $bp->bp_options_nav[$bp->groups->current_group->slug]['forum']['name'] = 'Discussion';
  }
}
add_action('bp_init', 'redirect_group_home' );
add_action('bp_init', 'move_group_activity_tab');

// Blow away BPs cookie to save sort options. So dumb.
if(isset($_COOKIE['bp-members-filter'])) {
  unset($_COOKIE['bp-members-filter']);
  setcookie('bp-members-filter', '', time() - 3600); // empty value and old timestamp
}

if(isset($_COOKIE['bp-members-scope'])) {
  unset($_COOKIE['bp-members-scope']);
  setcookie('bp-members-scope', '', time() - 3600); // empty value and old timestamp
}

if(isset($_COOKIE['bp-groups-scope'])) {
  unset($_COOKIE['bp-groups-scope']);
  setcookie('bp-groups-scope', '', time() - 3600); // empty value and old timestamp
}

function modify_members_list($query) {
	if ( empty( $query ) && empty( $_POST ) ) {
	    $query = '&per_page=50';
	}
	$query = '&per_page=50';
	return $query;
}

add_filter('bp_ajax_querystring','modify_members_list');

// Disable commenting on activity stream
add_filter( 'bp_activity_can_comment', '__return_false' );

?>
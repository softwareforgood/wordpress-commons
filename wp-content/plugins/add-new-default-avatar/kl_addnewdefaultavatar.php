<?php
/*
Plugin Name: Add New Default Avatar
Plugin URI: http://trepmal.com/plugins/add-new-default-avatar/
Description: Add new option to the Default Avatar list.
Author: Kailey Lampert
Version: 1.3.1
Author URI: http://kaileylampert.com/
*/
/*
	Copyright (C) 2011-12 Kailey Lampert

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

new Add_New_Default_Avatar( );

class Add_New_Default_Avatar {

	function __construct( ) {
		add_filter( 'init' , array( &$this , 'init' ), 9 );
		register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );

		add_filter( 'plugin_action_links_'. plugin_basename( __FILE__ ), array( &$this, 'plugin_action_links' ), 10, 4 );
		add_filter( 'admin_init' , array( &$this , 'admin_init' ) );
		add_filter( 'avatar_defaults' , array( &$this , 'avatar_defaults' ) );
		add_filter( 'get_avatar', array( &$this, 'get_avatar' ), 10, 5 );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );
	}

	function init() {
		//move away from kl_ prefix
		$opts = get_option( 'kl_addnewdefaultavatar', false );
		if ( $opts ) {
			update_option( 'add_new_default_avatar', $opts );
			delete_option( 'kl_addnewdefaultavatar' );
		}

		$opts = get_option( 'add_new_default_avatar', false );
		//upgrade option, we can now save multiple avatar options
		if ( isset( $opts['name'] ) ) {
			$opts = array( $opts );
			update_option('add_new_default_avatar', $opts );
		}

		if ( ! $opts ) return;

		//get current default opton
		$current = get_option( 'avatar_default' );

		//get any custom created avatars
		$unavailable = wp_list_pluck( $opts, 'url' );

		//if the current wasn't created by this plugin, update the backup
		if ( ! in_array( $current, $unavailable ) )
			update_option( 'pre_anda_avatar_default', $current );

	}

	function deactivate() {
		//on deactivation, restore backup
		update_option( 'avatar_default', get_option( 'pre_anda_avatar_default', 'mystery' ) );
	}

	function plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {
		if ( is_plugin_active( $plugin_file ) )
			$actions[] = '<a href="' . admin_url('options-discussion.php#add_new_default_avatar') . '">Setup</a>';
		return $actions;
	}
	function admin_init() {
		register_setting( 'discussion', 'add_new_default_avatar', array( &$this, 'validate') );
		add_settings_field('add_new_default_avatar', __('Add New Default Avatar' , 'anda' ) , array( &$this, 'field_html') , 'discussion', 'avatars', $args = array() );
	}

	function field_html() {
		$value = get_option( 'add_new_default_avatar', array( array( 'name' => 'Custom Avatar', 'url' => 'http://colorto.me/png/%size%/row2/purple/yellow/orange/blue.png' ) ) );

		foreach( $value as $k => $pair ) {
			extract( $pair );
			echo "<p><input type='text' name='add_new_default_avatar[$k][name]' value='$name' size='15' />";
			echo "<input type='text' name='add_new_default_avatar[$k][url]' value='$url' size='35' /></p>";
		}

		$uid = uniqid();
		echo "<input type='hidden' id='add_new_default_avatar_garbage' value='$uid' />";
		echo "<p id='add_new_default_avatar'><input type='text' name='add_new_default_avatar[$uid][name]' value='' size='15' />";
		echo "<input type='text' name='add_new_default_avatar[$uid][url]' value='' size='35' /></p>";

		echo "<a href='#' id='add_new_default_avatar_add' class='hide-if-no-js'>Add another</a>";

		echo '<p>' . __( 'Some themes won\'t resize your image to fit, so it\'s best to use an image that\'s already the right size.', 'anda' );

		echo '<br />';
		echo sprintf( __( 'However if your image accepts a size argument, you can use %1$s. Example: %2$s', 'anda' ), '<code>%size%</code>', '<code>http://colorto.me/png/%size%/row2/purple/yellow/orange/blue.png</code>' ) . '</p>';

	}

	function validate( $input ) {
		foreach( $input as $k => $pair ) {
			$input[ $k ]['name'] = esc_attr( $pair['name'] );
			$input[ $k ]['url'] = esc_url( $pair['url'] );
			if ( empty( $pair['name'] ) && empty( $pair['url'] ) ) {
				unset( $input[ $k ] );
			}
		}
		return $input;
	}

	function avatar_defaults( $avatar_defaults ) {
		$opts = get_option( 'add_new_default_avatar', false );
		if ( $opts ) {
			foreach( $opts as $k => $pair ) {
				// ensures matching so correct option will be selected in admin
				$av = html_entity_decode(  $pair['url'] );
				$avatar_defaults[ $av ] = $pair['name'];
			}
		}
		return $avatar_defaults;
	}

	function get_avatar( $avatar, $id_or_email, $size, $default='', $alt ) {

		if ( is_numeric( $id_or_email ) ) {
			$email = get_userdata( $id_or_email )->user_email;
			$user_id = (int) $id_or_email;
		}
		elseif ( is_object( $id_or_email ) ) {
			$email = $id_or_email->comment_author_email;
			$user_id = (int) $id_or_email->user_id;
		}
		elseif ( is_string( $id_or_email ) && ( $user = get_user_by( 'email', $id_or_email ) ) ) {
			$email = $id_or_email;
			$user_id = $user->ID;
		}

		// special exception for our 10up friends
		// http://wordpress.org/extend/plugins/simple-local-avatars/
		// (and check hook suffix while we're at it, if the current user has a simple_local_avatar, it'll throw the list off)
		$local_avatars = get_user_meta( $user_id, 'simple_local_avatar', true );
		if ( ! empty( $local_avatars ) && ( isset( $GLOBALS['hook_suffix'] ) && $GLOBALS['hook_suffix'] != 'options-discussion.php' ) ) {
			remove_filter( 'get_avatar', array( &$this, 'get_avatar' ), 88, 5 );
			return $avatar;
		}

		// since we're hooking directly into get_avatar,
		// we need to make sure another avatar hasn't been selected
		/* Once upon a time was needed for Mr WordPress. Do we care?
		$direct = get_option('avatar_default');
		if ( strpos( $default, $direct ) !== false ) {
			$email = empty( $email ) ? 'nobody' : md5( $email );

			// in rare cases were there is no email associated with the comment (like Mr WordPress)
			// we have to work around a bit to insert the custom avatar
			// 'www' version for WP2.9 and older
			if ( strpos( $default, 'http://0.gravatar.com/avatar/') === 0 || strpos( $default, 'http://www.gravatar.com/avatar/') === 0 )
				$avatar = str_replace( $default, $direct, $avatar );

		}
		*/
		// hack the correct size parameter back in, if necessary
		$avatar = str_replace( '%size%', $size, $avatar );
		$avatar = str_replace( urlencode('%size%'), $size, $avatar );
		return $avatar;
	}

	function admin_enqueue_scripts( $hook ) {
		if ( $hook != 'options-discussion.php' ) return;
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'anda', plugins_url( 'anda.js', __FILE__ ), array('jquery'), '', true );
	}

}
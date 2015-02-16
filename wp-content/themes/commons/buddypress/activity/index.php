<?php do_action( 'bp_before_directory_activity' ); ?>

<div id="buddypress">

  <?php do_action( 'bp_before_directory_activity_content' ); ?>

  <?php do_action( 'template_notices' ); ?>

  <div class="item-list-tabs activity-type-tabs" id="object-nav" role="navigation">
    <ul>
      <?php do_action( 'bp_before_activity_type_tab_all' ); ?>

      <?php if ( is_user_logged_in() ) : ?>

        <?php do_action( 'bp_before_activity_type_tab_friends' ); ?>

        <?php if ( bp_is_active( 'friends' ) ) : ?>

          <?php if ( bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

            <li id="activity-friends"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_friends_slug() . '/'; ?>" title="<?php esc_attr_e( 'The activity of my friends only.', 'buddypress' ); ?>"><?php printf( __( 'My Friends <span>%s</span>', 'buddypress' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ); ?></a></li>

          <?php endif; ?>

        <?php endif; ?>

        <?php do_action( 'bp_before_activity_type_tab_groups' ); ?>

        <?php if ( bp_is_active( 'groups' ) ) : ?>

          <?php if ( bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>

            <li class="selected" id="activity-groups"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_groups_slug() . '/'; ?>" title="<?php _e( 'The activity of groups I am a member of.', 'buddypress' ); ?>"><?php printf( __( 'My Groups <span>%s</span>', 'buddypress' ), number_format_i18n( bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) ); ?></a></li>

          <?php endif; ?>

        <?php endif; ?>

      <?php endif; ?>

      <li id="activity-all"><a href="<?php bp_activity_directory_permalink(); ?>" title="<?php _e( 'The public activity for everyone on this site.', 'buddypress' ); ?>"><?php printf( __( 'All Members <span>%s</span>', 'buddypress' ), number_format_i18n( bp_get_total_member_count() ) ); ?></a></li>

      <?php do_action( 'bp_activity_type_tabs' ); ?>
    </ul>
  </div><!-- .item-list-tabs -->

  <div class="item-list-tabs no-ajax" id="subnav" role="navigation">
    <ul>
      <li class="feed"><a href="<?php bp_sitewide_activity_feed_link(); ?>" title="<?php esc_attr_e( 'RSS Feed', 'buddypress' ); ?>"><?php _e( 'RSS', 'buddypress' ); ?></a></li>

      <?php do_action( 'bp_activity_syndication_options' ); ?>

      <li id="activity-filter-select" class="last">
        <label for="activity-filter-by"><?php _e( 'Show:', 'buddypress' ); ?></label>
        <select id="activity-filter-by">
          <option value="-1"><?php _e( '&mdash; Everything &mdash;', 'buddypress' ); ?></option>

          <?php bp_activity_show_filters(); ?>

          <?php do_action( 'bp_activity_filter_options' ); ?>

        </select>
      </li>
    </ul>
  </div><!-- .item-list-tabs -->

  <?php do_action( 'bp_before_directory_activity_list' ); ?>

  <div class="activity" role="main">

    <?php bp_get_template_part( 'activity/activity-loop' ); ?>

  </div><!-- .activity -->

  <?php do_action( 'bp_after_directory_activity_list' ); ?>

  <?php do_action( 'bp_directory_activity_content' ); ?>

  <?php do_action( 'bp_after_directory_activity_content' ); ?>

  <?php do_action( 'bp_after_directory_activity' ); ?>

</div>

<?php

/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php do_action( 'bp_before_member_header' ); ?>

<div id="item-header-content" class="ninecol first">

  <?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
    <h2 class="user-nicename"><?php bp_displayed_user_fullname(); ?></h2>
    <?php if(bp_get_member_profile_data('field=Work Email')) { ?>
      <span class="phone"><a href="mailto:<?php bp_member_profile_data( 'field=Work Email' );?>"><?php bp_member_profile_data( 'field=Work Email' );?></a></span><br />
    <?php } if(bp_get_member_profile_data('field=Phone Number')) { ?>
      <span class="phone"><?php bp_member_profile_data( 'field=Phone Number' );?></span>
    <?php } ?>
  <?php endif; ?>

  <!-- <span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span> -->

  <?php do_action( 'bp_before_member_header_meta' ); ?>

  <div id="item-meta">

    <div id="item-buttons">

      <?php do_action( 'bp_member_header_actions' ); ?>

    </div><!-- #item-buttons -->

    <div class="socialLinks">

      <?php
        /***
        * If you'd like to show specific profile fields here use:
        * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
        */

        do_action( 'bp_profile_header_meta' );

      ?>

      <?php if(bp_get_member_profile_data('field=Facebook')) { ?>
        <span class="facebook"><a target="_blank" href="<?php bp_member_profile_data( 'field=Facebook' ); ?>"></a></span>
      <?php } if(bp_get_member_profile_data('field=Twitter')) { ?>
        <span class="twitter"><a target="_blank" href="<?php bp_member_profile_data( 'field=Twitter' ); ?>"></a></span>
      <?php } if(bp_get_member_profile_data('field=Linkedin')) { ?>
        <span class="linkedin"><a target="_blank" href="<?php bp_member_profile_data( 'field=Linkedin' ); ?>"></a></span>
      <?php } ?>
    </div>


  </div><!-- #item-meta -->

</div><!-- #item-header-content -->


<div id="item-header-avatar" class="threecol last">
  <div class="elastic-avatar" style="background-image: url(<?php bp_displayed_user_avatar(array('html'=>false,'type'=>'full'));?>);">
    <img src="<?php echo get_template_directory_uri(); ?>/library/images/elastic-avatar-bg.gif" />
  </div>
</div><!-- #item-header-avatar -->


<?php do_action( 'bp_after_member_header' ); ?>

<?php do_action( 'template_notices' ); ?>
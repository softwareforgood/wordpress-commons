<?php

do_action( 'bp_before_group_header' );

?>

<div class="group-title-meta">
  <h2><?php bp_group_name(); ?></h2>
  <?php do_action( 'bp_before_group_header_meta' ); ?>
  <?php do_action( 'bp_group_header_actions' ); ?>
  <?php
    $group_id = bp_get_current_group_id();

    // Get File count
    $args = array (
      'post_type'      => 'bp_doc',
      'tax_query'         => array(
        array(
          'taxonomy' => 'bp_docs_associated_item',
          'field' => 'slug',
          'terms' => 'bp_docs_associated_group_'. $group_id
        )
      ),
    );

    $query = new WP_Query( $args );
    // Restore original Post Data
    wp_reset_postdata()
  ?>
  <div class="clearfix group-meta">
    <span><?php bp_group_member_count(); ?></span>
    <span><?php echo $query->found_posts; ?> Files</span>
    <span><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>
  </div>
</div>

<div class="group-description">
  <?php bp_group_description(); ?>
</div>

<?php
do_action( 'bp_after_group_header' );
do_action( 'template_notices' );
?>
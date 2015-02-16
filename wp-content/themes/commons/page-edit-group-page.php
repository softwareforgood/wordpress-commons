<?php

acf_form_head();

get_header();

the_post();

$param_ID = $_GET['edit'];
$param_DELETED = $_GET['trashed'];

?>
  <div id="content" class="group-page">

    <div id="inner-content" class="wrap clearfix">

        <div class="sidebar threecol first clearfix">

          <?php include(TEMPLATEPATH . '/buddypress/groups/groups-sidebar.php'); ?>

        </div>

        <div id="main" class="ninecol last clearfix" role="main">

          <div class="post section-header">
            <?php if ( $param_DELETED != 1 ) : ?>
              <a onclick="return confirm('Are you sure you want to delete this page?')" href="<?php echo get_delete_post_link( $param_ID ) ?>" class="caution-link right-float">Delete Page</a>
            <?php else :
                $_wpnonce = wp_create_nonce( 'untrash-post_' . $param_ID );
                $url = admin_url( 'post.php?post=' . $param_ID . '&action=untrash&_wpnonce=' . $_wpnonce );
            ?>
              <a onclick="return confirm('Are you sure you want to restore this page?')" href="<?php echo $url; ?>" class="caution-link right-float">Undo Delete</a>
            <?php endif; ?>
            <h1 class="h3">
              Edit Group Page
              <?php if ($param_DELETED == 1 ) : ?>
                (deleted)
              <?php endif; ?>
            </h1>
          </div>


          <div id="edit">

            <?php

              $acf_fields = get_page_by_title( 'Group Page', '', 'acf' );

              $args = array(
                'post_id' => $param_ID,
                'field_groups' => array( $acf_fields->ID ),
                'submit_value' => 'Update Page',
                'updated_message' => 'Group page updated.',
                'return' => add_query_arg( 'updated', 'true', get_permalink($param_ID) )
              );

              acf_form( $args );

            ?>

          </div>

        </div> <!-- end #main -->

    </div> <!-- end #inner-content -->

  </div> <!-- end #content -->

<?php get_footer(); ?>
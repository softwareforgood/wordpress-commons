<?php

acf_form_head();

get_header();

the_post();

$group_ID = $_GET['id'];

?>

  <div id="content" class="group-page">

    <div id="inner-content" class="wrap clearfix">

        <div class="sidebar threecol first clearfix">

          <?php include(TEMPLATEPATH . '/buddypress/groups/groups-sidebar.php'); ?>

        </div>

        <div id="main" class="ninecol last clearfix" role="main">

          <div class="post section-header">
            <?php
              global $bp;
              $group = groups_get_group( array( 'group_id' => $group_ID ) );
            ?>
            <a href="<?php echo get_bloginfo('url') . '/groups/' . $group->slug . '/'; ?>" class="right-float">Back to <?php echo $group->name; ?></a>
            <h1 class="h3">Create New Group Page</h1>

            <?php if( isset($_GET['post_id']) ) { ?>

              <div class="alert-success"><span>Thanks! Your group page has been created.</span></div>

            <?php } ?>
          </div>

          <div id="create">

            <?php

              $acf_fields = get_page_by_title( 'Group Page', '', 'acf' );

              $args = array(
                'post_id' => 'new',
                'post_type' => 'groups-page',
                'field_groups' => array( $acf_fields->ID ),
                'submit_value' => 'Create Page',
                'updated_message' => 'Group page created.',
                'return' => add_query_arg( 'id', $group_ID )
              );

              acf_form( $args );

            ?>

          </div>

        </div> <!-- end #main -->

    </div> <!-- end #inner-content -->

  </div> <!-- end #content -->

<?php get_footer(); ?>
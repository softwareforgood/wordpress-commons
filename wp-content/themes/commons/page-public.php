<?php
/*
Template Name: Public Page
*/
?>

<?php get_header(); ?>

      <div id="content">

        <div id="inner-content" class="wrap clearfix">

          <?php include ('public-sidebar.php'); ?>

          <div id="main" class="ninecol last clearfix" role="main">

            <div class="public-page-header">
              <?php
                $welcome = get_page_by_title( 'Welcome to the Commons');
                echo '<div class="article-header"><h1>' . $welcome->post_title . '</h1></div>';
                echo apply_filters('the_content',$welcome->post_content);
              ?>
            </div>

            <div id="buddypress">
              <div id="item-nav" class="clearfix">
                <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                  <?php wp_nav_menu( array(
                    'menu' => 'Public Pages Nav',
                    'depth' => 1
                  )); ?>
                </div>
              </div>
              <div class="item-list-tabs no-ajax clearfix" id="subnav" role="navigation">
                <?php
                  if($post->post_parent)
                    $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
                  else
                    $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
                  if ($children) { ?>
                    <?php wp_nav_menu( array(
                      'menu' => 'About Page Subnav',
                      'depth' => 1
                    )); ?>
                  <?php } ?>
              </div>
            </div>

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

              <section class="entry-content clearfix" itemprop="articleBody">
                <?php the_content(); ?>
              </section> <!-- end article section -->

              <footer class="article-footer">
                <p class="clearfix"><?php the_tags( '<span class="tags">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '' ); ?></p>
              </footer> <!-- end article footer -->

            </article> <!-- end article -->

            <?php endwhile; else : ?>

                <article id="post-not-found" class="hentry clearfix">
                    <header class="article-header">
                      <h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
                  </header>
                    <section class="entry-content">
                      <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
                  </section>
                  <footer class="article-footer">
                      <p><?php _e( 'This is the error message in the page-custom.php template.', 'bonestheme' ); ?></p>
                  </footer>
                </article>

            <?php endif; ?>

          </div> <!-- end #main -->

        </div> <!-- end #inner-content -->

      </div> <!-- end #content -->

<?php get_footer(); ?>

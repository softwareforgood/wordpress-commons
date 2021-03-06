<?php get_header(); ?>

      <div id="content">

        <div id="inner-content" class="wrap clearfix">

            <?php get_sidebar(); ?>

            <div id="main" class="ninecol last clearfix" role="main">

              <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

              <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                <header class="article-header clearfix">

                  <?php if( isset($_GET['updated']) ) { ?>

                    <div class="alert-success"><span>Your group page has been updated.</span></div>

                  <?php } ?>

                  <h1 class="ninecol entry-title single-title" itemprop="headline">
                    <?php the_title(); ?>
                    <?php if (get_post_status( $post_id ) ==='trash') : ?>
                      (deleted)
                    <?php endif; ?>
                  </h1>

                  <?php
                    global $current_user;
                    get_currentuserinfo();

                    if(get_field('this_group')) {
                      $field = get_field_object('this_group');
                      $group_id = $field['value'];
                    }

                    if ($current_user->ID == $post->post_author) { ?>
                      <span class="threecol text-right">
                        <a href="<?php echo get_bloginfo('url'); ?>/edit-group-page?edit=<?php the_ID(); ?>&id=<?php echo $group_id; ?>" class="blue-button btn-medium">Edit Page</a>
                      </span>
                  <?php } ?>

                </header>

                <div class="meta-box clearfix">
                  <div class="avatar member-avatar-wrap">
                    <?php echo get_avatar( $post->post_author ); ?>
                  </div>
                  <div class="uppercase">
                    <?php printf( __( 'By <span class="author">%s</span>', 'buddypress' ), str_replace('<a href=', '<a rel="author" href=', bp_core_get_userlink($post->post_author))); ?>
                    <?php printf( __( '- <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'bonestheme' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
                    <?php // the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>
                  </div>

                </div>

                <section class="entry-content clearfix" itemprop="articleBody">

                  <?php if( get_field('page_content') ) :
                    $field = get_field_object('page_content');
                    echo '<div class="field ' . $field['name'] . '" id="' . $field['key'] . '">';
                    echo $field['value'];
                    echo '</div>';
                  endif; ?>

                </section>

                <footer class="article-footer">
                  <?php the_tags( '<span class="tags">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '' ); ?>

                </footer> <!-- end article footer -->

                <?php comments_template(); ?>

              </article> <!-- end article -->

              <?php endwhile; else : ?>

                  <article id="post-not-found" class="hentry clearfix">
                    <header class="article-header">
                      <h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
                    </header>
                    <section class="entry-content">
                      <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
                    </section>
                  </article>

              <?php endif; ?>

            </div> <!-- end #main -->

        </div> <!-- end #inner-content -->

      </div> <!-- end #content -->

<?php get_footer(); ?>

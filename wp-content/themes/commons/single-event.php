<?php get_header(); ?>

      <div id="content">

        <div id="inner-content" class="wrap clearfix">

          <?php get_sidebar(); ?>

          <div id="main" class="ninecol last clearfix" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

              <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                <header class="article-header">

                  <?php
                    $event_ID = do_shortcode("[event]#_EVENTID[/event]");
                    $EM_Event = em_get_event($event_ID);

                    if( $EM_Event->can_manage('edit_events','edit_others_events') ){
                      echo do_shortcode('[event]<p class="editEvent"><a href="#_EDITEVENTURL">Edit Event</a></p>[/event]');
                    }
                  ?>

                  <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>

                </header> <!-- end article header -->

                <p class="small">Add to:
                  <?php echo do_shortcode('[event]<a href="#_EVENTICALURL">Desktop Calendar</a>[/event]'); ?> |
                  <?php echo do_shortcode('[event]<a href="#_EVENTGCALURL" target="_blank">Google Calendar</a>[/event]'); ?>
                </p>
                <div class="meta-box clearfix">
                  <div class="avatar member-avatar-wrap">
                    <?php echo get_avatar( $post->post_author ); ?>
                  </div>
                  <div class="uppercase">
                    <?php printf( __( 'By <span class="author">%3$s</span> - <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link() ); ?>
                  </div>
                  <div class="spaced-out">
                    <span><a href="#comments"><?php comments_number(); ?></a></span>
                  </div>
                </div>

                <section class="entry-content clearfix" itemprop="articleBody">
                  <?php the_content(); ?>
                </section> <!-- end article section -->

                <footer class="article-footer">
                  <?php the_tags( '<p class="tags"><span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '</p>' ); ?>

                </footer> <!-- end article footer -->

                <?php comments_template(); ?>

              </article> <!-- end article -->

            <?php endwhile; ?>

            <?php else : ?>

              <article id="post-not-found" class="hentry clearfix">
                  <header class="article-header">
                    <h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
                  </header>
                  <section class="entry-content">
                    <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
                  </section>
                  <footer class="article-footer">
                      <p><?php _e( 'This is the error message in the single.php template.', 'bonestheme' ); ?></p>
                  </footer>
              </article>

            <?php endif; ?>

          </div> <!-- end #main -->

        </div> <!-- end #inner-content -->

      </div> <!-- end #content -->

<?php get_footer(); ?>

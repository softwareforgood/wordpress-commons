<?php get_header(); ?>

      <div id="content">

        <div id="inner-content" class="wrap clearfix">

          <?php get_sidebar(); ?>

          <div id="main" class="ninecol last clearfix search-results" role="main">
            <div class="search section-header">
              <h1 class="archive-title"><span><?php _e( 'Search Results for', 'bonestheme' ); ?></span> &ldquo;<?php echo esc_attr(get_search_query()); ?>&rdquo;</h1>
            </div>
            <div class="search-separator"></div>
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

              <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix search-article'); ?> role="article">
                <div class="color-bar"></div>
                <header class="article-header">
                  <h3 class="search-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                  <div class="meta-box clearfix">
                    <div class="avatar member-avatar-wrap">
                      <?php echo get_avatar( $post->post_author ); ?>
                    </div>
                    <div class="uppercase">
                      <?php printf( __( 'By <span class="author">%3$s</span> - <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') ); ?>
                    </div>
                    <div class="spaced-out">
                      <?php
                        $searchcat = get_the_category();
                        if(!empty($searchcat)) { ?>
                          <span><?php printf( __( '%4$s', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );?></span>
                          |
                      <?php } ?>
                      <span><a href="#comments"><?php comments_number(); ?></a></span>
                    </div>
                  </div>

                </header> <!-- end article header -->

                <section class="entry-content">
                    <?php the_excerpt( '<span class="read-more">' . __( 'Read more &raquo;', 'bonestheme' ) . '</span>' ); ?>

                </section> <!-- end article section -->

                <footer class="article-footer">

                </footer> <!-- end article footer -->

              </article> <!-- end article -->

            <?php endwhile; ?>

                <?php if (function_exists('bones_page_navi')) { ?>
                    <?php bones_page_navi(); ?>
                <?php } else { ?>
                    <nav class="wp-prev-next">
                        <ul class="clearfix">
                          <li class="prev-link"><?php next_posts_link( __( '&laquo; Older Entries', 'bonestheme' )) ?></li>
                          <li class="next-link"><?php previous_posts_link( __( 'Newer Entries &raquo;', 'bonestheme' )) ?></li>
                        </ul>
                    </nav>
                <?php } ?>

              <?php else : ?>

                  <article id="post-not-found" class="hentry clearfix">
                    <header class="article-header">
                      <h1><?php _e( 'Sorry, No Results.', 'bonestheme' ); ?></h1>
                    </header>
                    <section class="entry-content">
                      <p><?php _e( 'Try your search again.', 'bonestheme' ); ?></p>
                    </section>
                  </article>

              <?php endif; ?>

          </div> <!-- end #main -->

        </div> <!-- end #inner-content -->

      </div> <!-- end #content -->

<?php get_footer(); ?>

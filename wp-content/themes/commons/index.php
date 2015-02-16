<?php get_header(); ?>

      <div id="content">

        <div id="inner-content" class="wrap clearfix">

            <?php get_sidebar(); ?>

            <div id="main" class="index ninecol last clearfix" role="main">

              <!-- <div class="post section-header"><h1 class="h3"><?php wp_title(''); ?></h1></div> -->

              <?php
                $slug = 'exclude-from-announcements';
                $category = get_category_by_slug($slug);
                query_posts($query_string . '&category__not_in=' . $category->cat_ID);
              ?>
              <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

              <article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> role="article">
                <div class="color-bar"></div>
                <header class="article-header">
                  <?php if ( has_post_thumbnail()) { ?>
                    <?php $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); ?>
                    <div class="elastic-avatar wide" style="background-image: url(<?php echo $image_url[0] ?>);">
                      <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/library/images/elastic-avatar-bg-wide.gif" />
                      </a>
                    </div>
                  <?php } ?>

                  <p class="byline vcard">
                    <?php printf( __( 'By <span class="author">%s</span>', 'buddypress' ), str_replace('<a href=', '<a rel="author" href=', bp_core_get_userlink($post->post_author))); ?>
                    <?php printf( __( '- <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'bonestheme' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
                  </p>

                  <h1 class="h2"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>

                </header> <!-- end article header -->

                <section class="entry-content clearfix">
                  <?php the_excerpt(); ?>
                </section> <!-- end article section -->

                <footer class="article-footer">
                  <div class="spaced-out">
                    <span><?php printf( __( '%4$s', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );?></span>
                    |
                    <span><a href="<?php the_permalink() ?>#comments"><?php comments_number(); ?></a></span>
                  </div>
                  <!-- <p class="tags"><?php the_tags( '<span class="tags-title">' . __( 'Tags:', 'bonestheme' ) . '</span> ', ', ', '' ); ?></p> -->
                </footer> <!-- end article footer -->

                <?php // comments_template(); // uncomment if you want to use them ?>

              </article> <!-- end article -->

              <?php endwhile; ?>

                  <?php if ( function_exists( 'bones_page_navi' ) ) { ?>
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

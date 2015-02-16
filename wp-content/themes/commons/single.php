<?php get_header(); ?>

      <div id="content">

        <div id="inner-content" class="wrap clearfix">

          <?php get_sidebar(); ?>

          <div id="main" class="ninecol last clearfix" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

              <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

                <div class="post-thumbnail">
                  <?php if ( has_post_thumbnail()) { ?>
                    <?php $image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full'); ?>
                    <div class="elastic-avatar wide" style="background-image: url(<?php echo $image_url[0] ?>);">
                      <img src="<?php echo get_template_directory_uri(); ?>/library/images/elastic-avatar-bg-wide.gif" />
                    </div>
                  <?php } ?>
                </div>

                <header class="article-header">

                  <h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>

                </header> <!-- end article header -->

                <div class="meta-box clearfix">
                  <div class="avatar member-avatar-wrap">
                    <?php echo get_avatar( $post->post_author ); ?>
                  </div>
                  <div class="uppercase">
                    <?php printf( __( 'By <span class="author">%s</span>', 'buddypress' ), str_replace('<a href=', '<a rel="author" href=', bp_core_get_userlink($post->post_author))); ?>
                    <?php printf( __( '- <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'bonestheme' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
                  </div>
                  <div class="spaced-out">
                    <?php
                      $thecategory = get_the_category();
                      if(!empty($thecategory)) { ?>
                        <span><?php printf( __( '%4$s', 'bonestheme' ), get_the_time( 'Y-m-j' ), get_the_time( get_option('date_format')), bones_get_the_author_posts_link(), get_the_category_list(', ') );?></span>
                        |
                    <?php } ?>
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
              </article>

            <?php endif; ?>

          </div> <!-- end #main -->

        </div> <!-- end #inner-content -->

      </div> <!-- end #content -->

<?php get_footer(); ?>

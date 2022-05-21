<?php
get_header();
if (have_posts()) {
    global $post; ?>
    <section class="content <?php echo $post->post_name; ?>">
    <?php if(is_front_page()) : ?>
        <section class="inner">
            <?php the_content(); ?>
        </section>
        <section class="blocks">
            <div class="block">
                <?php dynamic_sidebar('block-l'); ?>
            </div>
            <div class="block">
                <?php dynamic_sidebar('block-m'); ?>
            </div>
            <div class="block">
                <?php dynamic_sidebar('block-r'); ?>
            </div>
        </section>
    <?php elseif(is_page(array('de-agenda','the-agenda'))) : ?>
        <section class="planning">
            <?php the_content(); ?>
            <?php echo do_shortcode('[dancal divid="calendar"]'); ?>
        </section>
    <?php elseif(is_page(array('diensten','services'))) : ?>
        <?php $the_query = new WP_Query(array('post_type'=> 'services',));
        if($the_query->have_posts() ) :
            while ( $the_query->have_posts() ) :
                $the_query->the_post();
                echo '<article class="service">';
                echo '<h2>'.get_the_title().'</h2>';
                the_content();
                echo '</article>';
            endwhile;
            wp_reset_postdata();
        endif; ?>
    <?php elseif(is_page(array('bestuur','board'))) : ?>
        <section class="boardmembers">
            <?php dynamic_sidebar('board-members'); ?>
        </section>
        <?php the_content(); ?>
    <?php elseif(is_page(array('commissies','committees'))) : ?>
        <section class="committees">
            <?php dynamic_sidebar('committees-page'); ?>
        </section>
        <?php the_content(); ?>
    <?php elseif(is_page(array('fotos','photos','fotodetails','photodetails'))) : ?>
        <h2><?php echo (is_single() || is_singular() || is_page() ? get_the_title() : '<a href="'.get_the_permalink().'">'.get_the_title().'</a>'); ?></h2>
        <?php the_content(); ?>
    <?php elseif(is_page(array('documenten','documents'))) : ?>
        <?php
        if (is_active_sidebar('documents')) {
            dynamic_sidebar('documents');
        }
        else {
            echo 'No content available.';
        }
        the_content();
        ?>
    <?php else : ?>
        <?php if(is_post_type_archive('games')) : ?>
            <div class="game_navi">
                <!-- Search -->
                <?php get_search_form(); ?>
                <!-- Tags -->
                <form id="gametypes" class="gametypes" action="<?php bloginfo('url'); ?>" method="get">
                    <?php
                    $args = array(
                        'show_option_all' => __('Gametype','improv'),
                        'hide_empty'      => false,
                        'echo'            => false,
                        'show_count'      => true,
                        'taxonomy'        => 'soort',
                        'name'            => 'soort',
                        'value_field'     => 'slug',
                        'selected'        => get_query_var( 'soort' ),
                    );
                    $select  = wp_dropdown_categories($args);
                    $replace = "<select$1 onchange='return this.form.submit()'>";
                    $select  = preg_replace('#<select([^>]*)>#',$replace, $select);
                    echo $select;
                    ?>
                    <noscript><input type="submit" value="View"></noscript>
                </form>
            </div>
            <div class="masonry">
                <article class="d-none">
                    <!-- display all tags -->
                </article>
                <?php $posts = query_posts($query_string.'&orderby=title&order=asc'); //var_dump($query_string); ?>
                <?php while (have_posts()) : the_post() ?>
                    <article>
                        <a href="<?php the_permalink(); ?>">
                            <h2><?php the_title(); ?></h2>
                            <?php the_excerpt(); ?>
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="tagline">
                Pro Deo's games database - de grootste van Nederland!
            </div>
        <?php else : ?>
            <?php
                $catlist = null;
                $cats = get_the_category();
                foreach($cats as $cat) {
                    $catlist .= $cat->slug.' ';
                }
                $colwidth = is_page(array('contact','contact-us')) ? 'col-lg-4' : 'col-lg-8';
                ?>
            <div class="row">
                <aside class="d-none d-lg-block col-lg-2 border-right ruler"></aside>
                <section class="col <?php echo $colwidth ?>">
                <?php while (have_posts()) : the_post() ?>
                    <article <?php echo (!is_null($catlist) ? 'class="'.trim($catlist).'"' : null); ?>>
                        <?php if(is_singular('games')): ?>
                            <script type="application/ld+json">
                            {
                                "@context": "https://schema.org",
                                "@type": "Game",
                                "name": "<?php echo html_entity_decode(get_the_title()); ?>",
                                "headline": "<?php echo html_entity_decode(get_the_title()); ?>",
                                "url": "<?php the_permalink(); ?>",
                                "quest":"<?php echo str_replace(array(',', '"','\''), '', strip_tags(get_the_content())); ?>",
                                "genre": "<?php echo strip_tags(get_the_term_list( get_the_ID(),'soort','',', ')); ?>",
                                "numberOfPlayers": "4",
                                "timeRequired": "PT4M",
                                "author": "<?php bloginfo('name'); ?>"
                            }
                        </script>
                        <?php endif; ?>
                        <h2><?php echo (is_single() || is_singular() || is_page() ? get_the_title() : '<a href="'.get_the_permalink().'">'.get_the_title().'</a>'); ?></h2>
                        <div class="row">
                            <div class="col col-10">
                                <?php the_content(); ?>
                            </div>
                            <div class="col col-2">
                                <?php the_post_thumbnail(); ?>
                                <?php if(is_singular('games')): ?>
                                    <?php the_terms(get_the_ID(), 'soort', 'Gamesoort: ', ' , '); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
                </section>
            <?php if(is_page(array('contact','contact-us'))) : ?>
                <aside class="col col-4 maps">
                    <?php dynamic_sidebar('contact-maps'); ?>
                </aside>
            <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    </section>
<?php }
get_footer();
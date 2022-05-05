    </div>
    <?php if(is_front_page()) : ?>
        <section class="container">
                <div id="instagram_feed">
                    <?php echo do_shortcode('[instagram feed="1574"]'); ?>
                </div>
        </section>
    <?php endif; ?>
</main>
<footer class="container-fluid py-3">
    <div class="container d-flex flex-column flex-lg-row justify-content-lg-between">
        <section>
            &copy; <?php echo date("Y"); echo ' '; echo bloginfo('name'); ?>
            <?php $contact_id = pll_current_language() == 'nl' ? 2 : 965 ?>
            - <a href="<?php the_permalink($contact_id); ?>"><?php echo get_the_title($contact_id); ?></a>
        </section>
        <?php $avg_id = pll_current_language() == 'nl' ? 3 : 1008 ?>
        <a href="<?php the_permalink($avg_id); ?>"><?php echo get_the_title($avg_id); ?></a>
    </div>
</footer>
<?php dynamic_sidebar('scripts-footer'); ?>
<?php wp_footer(); ?>
</body>
</html>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php
    if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	}
	?>
    <?php get_header(); ?>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.1/dist/cdn.min.js" defer></script>

    <div class="configurator-overlay">
        <div class="container xl:overflow-visible overflow-auto">
            <div class="default-grid grid-container">
                <?php
                $copy_text = get_field('copy_text');
                if ($copy_text) {
                    echo '<h2 class="copy-text xl:col-start-2 xxl:col-span-full  col-span-full headline-h4 mb-32">' . esc_html($copy_text) . '</h2>';
                }
                ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                        <div class="hidden xl:block xxl:hidden"></div>
                        <?php
                        $bundles = get_field('product_bundles');
                        if ($bundles) :
                            foreach ($bundles as $bundle) :
                                $product = wc_get_product($bundle->ID);
                        ?>
                                <div class="fifty-fifty-card bg-fsGrey-50 transition-all duration-300" x-data="{ isExpanded: false }">
                                    <div class="fifty-fifty-image-container">
                                        <?php echo get_the_post_thumbnail($bundle->ID, 'full'); ?>
                                    </div>
                                    <h3 class="fifty-fifty-headline">
                                        <?php echo esc_html($bundle->post_title); ?>
                                    </h3>
                                    <div class="fifty-fifty-copy">
                                        <?php echo esc_html($bundle->post_excerpt) ?>
                                    </div>
                                    <div class="additional-details fifty-fifty-copy" :style="{ maxHeight: isExpanded ? '1000px' : '0' }">
                                        <?php echo apply_filters('the_content', $bundle->post_content); ?>
                                    </div>
                                    <div class="fifty-fifty-button-container">
                                        <a href="<?php echo esc_url(get_permalink($bundle->ID)); ?>" class="select-variant-button">
                                            Select - $<?php echo esc_html($product->get_price()); ?>
                                        </a>
                                        <button @click="isExpanded = !isExpanded" class="configurator-secondary-button">
                                            <span x-text="isExpanded ? 'Show Less' : 'Show More'"></span>
                                        </button>
                                    </div>
                                </div>
                <?php endforeach;
                        endif;
                    endwhile;
                endif; ?>
            </div>
        </div>
    </div>

    <?php get_footer(); ?>
    <?php wp_footer(); ?>
</body>

</html>
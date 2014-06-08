<?php
/**
 * Template Name: Main Press Page
 *
 * This template is for the main press page only. It is a collection of the various
 * press items in the site. Even though this is a page, it is not customizable.
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */

get_header(); ?>

<?php
    $press_pages = get_pages(array(
        'sort_column' => 'post_date',
        // This page.
        'child_of' => get_the_ID(),
    ));
    //foreach($press_pages as $press_page) {
    //    echo $press_page->post_title.' '. $press_page->_wp_page_template.'<br />';
    //}
?>

    <div id="press">

        <div class="column1">
        <?php
        $i=0;
        foreach ( $press_pages as $press_page ) : ?>
            <?php if ( $press_page->_wp_page_template == 'default' || $press_page->_wp_page_template == 'page-templates/two-column.php' || $press_page->_wp_page_template == 'page-templates/three-column.php' ) : ?>
                <?php if ( $i == 0 ) : ?>
                    <div class="featured_story">
                        <h1><a href="<?php echo get_page_link( $press_page->ID ) ?>"><?php echo $press_page->post_title ?></a></h1>
                        <?php
                            $featured_images = rwmb_meta( 'page_article_thumb', 'type=image&size=press-article-thumbnail', $press_page->ID );
                            $featured_image = reset($featured_images);
                        ?>
                        <p><a href="<?php echo get_page_link( $press_page->ID ) ?>"><img src="<?php echo $featured_image['url'] ?>" /></a></p>
                        <p><a href="<?php echo get_page_link( $press_page->ID ) ?>"><?php echo rwmb_meta( 'page_short_summary', '', $press_page->ID ) ?></a></p>
                    </div>
                <?php else : ?>
                    <div class="story">
                        <h2><a href="<?php echo get_page_link( $press_page->ID ) ?>"><?php echo $press_page->post_title ?></a></h2>
                        <p><a href="<?php echo get_page_link( $press_page->ID ) ?>"><?php echo rwmb_meta( 'page_short_summary', '', $press_page->ID ) ?></a></p>
                    </div>
                <?php endif;
                $i+=1; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        </div>

        <div class="column2">
            <h1>Featured Recipes</h1>
            <ul>
        <?php foreach ( $press_pages as $press_page ) : ?>
            <?php if ( $press_page->_wp_page_template == 'page-templates/press-link.php' ) : ?>
                <li><a href="<?php echo rwmb_meta( 'page_link_url', '', $press_page->ID ) ?>"><?php echo $press_page->post_title ?></a></li>
            <?php endif; ?>
        <?php endforeach; ?>
            </ul>
        </div>

        <div class="column3">
            <h1>Featured Videos</h1>
            <ul>
        <?php foreach ( $press_pages as $press_page ) : ?>
            <?php if ( $press_page->_wp_page_template == 'page-templates/press-video.php' ) : ?>
                <li>
                    <a href="<?php echo get_page_link( $press_page->ID ) ?>"><?php echo get_the_post_thumbnail($press_page->ID, 'video-thumbnail'); ?></a>
                    <p><?php echo $press_page->post_title ?></p>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
            </ul>
        </div>

    </div>

    <!--
        <h1><?php the_title(); ?></h1>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="feature_image">
            <?php the_post_thumbnail('page-feature-full'); ?>
        </div>
    <?php endif; ?>
        <div class="column1">
            <?php echo rwmb_meta( 'page_column_1' ) ?>
        </div>
        <div class="column2">
            <?php echo rwmb_meta( 'page_column_2' ) ?>
        </div>
    </div>
    -->

<?php get_footer(); ?>
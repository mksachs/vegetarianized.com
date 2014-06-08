<?php
/**
 * 
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default. It is a
 * one column layout. Additional layouts are in the page-templates
 * directory.
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */

get_header(); ?>

    <div id="page" class="one_column">
        <h1><?php the_title(); ?></h1>

    <?php if ( rwmb_meta( 'page_subtitle' ) != '' ) : ?>
        <h2><?php echo rwmb_meta( 'page_subtitle' ); ?></h2>
    <?php endif; ?>

    <?php if ( has_post_thumbnail() ) : ?>
        <div class="feature_image">
            <?php the_post_thumbnail('page-feature-full'); ?>
        </div>
    <?php endif; ?>

    <?php // add in the credits div if needed ?>
    <?php if ( rwmb_meta( 'page_author' ) != '' || rwmb_meta( 'page_photographer' ) != '' || rwmb_meta( 'page_published_in' ) != '' || rwmb_meta( 'page_original_article_url' ) != '' ) : ?>
        <div class="credits">
        <?php if ( rwmb_meta( 'page_author' ) != '' ) : ?>
            <h3>By <?php echo rwmb_meta( 'page_author' ) ?></h3>
        <?php endif; ?>

        <?php if ( rwmb_meta( 'page_photographer' ) != '' ) : ?>
            <h3>Photos by <?php echo rwmb_meta( 'page_photographer' ) ?></h3>
        <?php endif; ?>

        <?php if ( rwmb_meta( 'page_published_in' ) != '' && rwmb_meta( 'page_original_article_url' ) != '' ) : ?>
            <h3>Originally published in <a href="<?php echo rwmb_meta( 'page_original_article_url' ) ?>"><?php echo rwmb_meta( 'page_published_in' ) ?></a></h3>
        <?php elseif ( rwmb_meta( 'page_published_in' ) != '' && rwmb_meta( 'page_original_article_url' ) == '' ) : ?>
            <h3>Originally published in <?php echo rwmb_meta( 'page_published_in' ) ?></h3>
        <?php elseif ( rwmb_meta( 'page_published_in' ) == '' && rwmb_meta( 'page_original_article_url' ) != '' ) : ?>
            <h3><a href="<?php echo rwmb_meta( 'page_original_article_url' ) ?>">View the original article.</a></h3>
        <?php endif; ?>

        </div>
    <?php endif; ?>
    
        <div class="column1">
            <?php echo rwmb_meta( 'page_column_1' ) ?>
        </div>
    </div>

<?php get_footer(); ?>
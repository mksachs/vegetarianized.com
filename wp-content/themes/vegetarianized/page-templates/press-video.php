<?php
/**
 * Template Name: Press Video Page
 *
 * This template is for an embeded video page.
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */

get_header(); ?>

    <div id="page" class="three_column">
        <h1><?php the_title(); ?></h1>

    <?php if ( rwmb_meta( 'page_video_embed_code' ) != '' ) : ?>
        <div class="feature_image">
            <?php echo rwmb_meta( 'page_video_embed_code' ); ?>
        </div>
    <?php endif; ?>

        <div class="column1">
        <?php if ( rwmb_meta( 'page_original_article_url' ) != '' ) : ?>
            <h3><a href="<?php echo rwmb_meta( 'page_original_article_url' ) ?>">Original video post &rarr;</a></h3>
        <?php endif; ?>

            <?php echo rwmb_meta( 'page_video_comments' ) ?>
        </div>
        <div class="column2"></div>
        <div class="column3"></div>
    </div>
    
<?php get_footer(); ?>
<?php
/**
 * Template Name: Press Link Page
 *
 * A link to a press article on an external site. This page is never viewed directly.
 * Having a link page in the site will add the link to the main press page.
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */

get_header(); ?>

    <div id="page" class="two_column">
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
    
    <!--
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-page-image">
						<?php //the_post_thumbnail(); ?>
					</div><!~~ .entry-page-image ~~>
				<?php endif; ?>

				<?php //get_template_part( 'content', 'page' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!~~ #content ~~>
	</div><!~~ #primary ~~>
    -->

<?php //get_sidebar( 'front' ); ?>
<?php get_footer(); ?>
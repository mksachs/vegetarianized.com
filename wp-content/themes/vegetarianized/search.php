<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */

get_header(); ?>

    <div id="search_results">
        <h1>Search results for "<?php echo get_search_query() ?>"</h1>
    <?php if ( have_posts() ) : ?>
        <ul>
        <?php while ( have_posts() ) : the_post(); ?>
            <li>
                <div class="column1">
                    <a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail(); ?></a>
                </div>
                <div class="column2">
                    <h2><?php the_title(); ?></h2>
                    <p class="date"><?php echo get_the_date(); ?></p>
                </div>
                <div class="column3">
                    <p class="caption"><?php echo substr(substr(rtrim(ltrim(rwmb_meta( 'recipe_description' ))), 3), 0, -4); ?></p>
                </div>
            </li>
        <?php endwhile; ?>
        </ul>
    <?php else : ?>
        <h2>No results! Please try a different search.</h2>
    <?php endif; ?>
    </div>

<?php get_footer(); ?>
<?php
/**
 * The template for displaying Category pages.
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */

get_header(); ?>

    <div id="search_results">
        <h1>Category: <?php single_cat_title(); ?></h1>

        <?php
            $args = array(
                'cat'   => get_cat_id( single_cat_title("",false) ),
                'post_type'     => 'recipe',
                'posts_per_page' => -1,
            );
            
            $to_echo = '';
            
            $posts_array = get_posts( $args );
        ?>

        <?php if ( count($posts_array) == 0 ) : ?>
            <p>Nuttin here</p>
        <?php else : ?>
            <ul>
            <?php foreach ( $posts_array as $post ) : ?>
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
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>

<?php get_footer(); ?>
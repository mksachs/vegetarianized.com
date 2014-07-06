<?php
/**
 * The main template file.
 *
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */

get_header(); ?>

<?php
    $args = array(
                'numberposts'   => 1,
                'offset'        => 0,
                'post_type'     => 'alert',
                'post_status'   => 'publish'
            );
        
        $current_alert = wp_get_recent_posts( $args );

    if ( sizeof($current_alert) != 0 ) :
?>

    <div id="alerts">
    <?php foreach( $current_alert as $alert ) : ?>
        <div class="alert">
            <div class="title">
                <?php echo $alert["post_title"]; ?>
            </div>
            <div class="message">
                <?php echo $alert["post_content"]; ?>
            </div>
            <div style="clear:both;"></div>
        </div>
    <?php endforeach; ?>
    </div>

<?php endif; ?>

<?php get_template_part( 'single', 'recipe' ); ?>

<!-- The recent items scroller -->
    <div id="recent" class="scroller">
        <h2>Recent</h2>
        <div class="scroller_content">
        <?php
            $args = array(
                    'numberposts' => 10,
                    'offset' => 1,
                    'post_type' => 'recipe',
                    'post_status' => 'publish'
            );
            
            $to_echo = '';
            
            $recent_posts = wp_get_recent_posts( $args );
            
            foreach( $recent_posts as $post ) :
        ?>
            <div class="scroller_item">
                <?php
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post["ID"]), 'post-thumbnail' );
                    $url = $thumb[0];
                    $width = $thumb[1];
                    $height = $thumb[2];
                ?>
                <!--<?php echo $width.' '.$height; ?>-->
                <img src="<?php echo $url ?>" />
                <p class="scroller_item_text"><a href="<?php echo get_permalink($post["ID"]) ?>"><?php echo __( $post["post_title"] ) ?></a></p>
                <div class="data">
                    <div class="img_width"><?php echo $width; ?></div>
                    <div class="img_height"><?php echo $height; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

<!-- The popular items scroller -->
<?php
    $args = array(
        'numberposts'   => 10,
        'post_type'     => 'recipe',
        'orderby'       => 'meta_value_num',
        'meta_key'      => 'recipe_views_count',
        'order'         => 'DESC',
        'post_status'   => 'publish',
        'meta_value'    => 0,
        'meta_compare'  => '!=',
    );
    
    $posts_array = get_posts( $args );
?>
<?php if ( count($posts_array) != 0 ) : ?>
    <div id="popular" class="scroller">
<?php else : ?>
    <div id="popular" class="scroller" style="display:none;">
<?php endif; ?>
        <h2>Popular</h2>
        <div class="scroller_content">
        <?php foreach( $posts_array as $post ) : ?>
            <div class="scroller_item">
                <?php
                    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'post-thumbnail' );
                    $url = $thumb[0];
                    $width = $thumb[1];
                    $height = $thumb[2];
                ?>
                <!--<?php echo get_the_post_thumbnail($post->ID); ?>-->
                <img src="<?php echo $url ?>" />
                <p class="scroller_item_text"><a href="<?php echo get_permalink($post->ID) ?>"><?php echo __( $post->post_title ) ?></a></p>
                <div class="data">
                    <div class="img_width"><?php echo $width; ?></div>
                    <div class="img_height"><?php echo $height; ?></div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

<!-- Sidebar -->
<div id="sidebar">
<?php if ( is_active_sidebar( 'googleanalytics_sidebar' ) ) : ?>
    <?php dynamic_sidebar( 'googleanalytics_sidebar' ); ?>
<?php endif; ?>
</div>

<?php get_footer(); ?>
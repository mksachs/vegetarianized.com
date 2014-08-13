<?php
/**
 * The template used for displaying single recipes.
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */
?>

<?php
    if ( !is_front_page() ) {
        get_header();
        $postID = $post->ID;
    
        set_recipe_views($postID);
    }

?>
    <?php // need this to get the post id from javascript ?>
    <?php echo '<input type="hidden" name="activepost" id="activepost" value="'.get_the_ID().'" />'; ?>

<!-- The feature. -->
    <div id="feature">
        <div class="column1">
            <?php echo get_the_post_thumbnail($post->ID, 'feature-full'); ?>
        </div>
        <div class="column2">
            <h1><?php the_title(); ?></h1>
            <p class="date"><?php echo get_the_date(); ?></p>
            <p class="caption"><?php echo substr(substr(rtrim(ltrim(rwmb_meta( 'recipe_description' ))), 3), 0, -4); ?></p>
        </div>
    </div>



<!-- The recipe scroller. This shows all of the images attached to the recipe. -->
    <div id="recipe_scroller" class="scroller">
        <div class="scroller_content">
            <!-- There is always at least the featured image here -->
            <div class="scroller_item">
            <?php
                $featured_image_thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
                $fixed_width = 155;
                $scale = $fixed_width/$featured_image_thumb_src[1];
            ?>
                <!--<img src="<?php echo $featured_image_thumb_src[0]; ?>" width="156" height="<?php echo $featured_image_thumb_src[2] * $scale; ?>" />-->
                <img src="<?php echo $featured_image_thumb_src[0]; ?>" />
                <div class="data">
                    <div class="img_width"><?php echo $fixed_width; ?></div>
                    <div class="img_height"><?php echo $featured_image_thumb_src[2] * $scale; ?></div>
                    <div class="img_caption"><?php echo __( substr(substr(rtrim(ltrim(rwmb_meta( 'recipe_description' ))), 3), 0, -4) ); ?></div>
                </div>
            </div>
            <!-- Now add the rest of the recipe images if there are any -->
        <?php
            $images = rwmb_meta( 'recipe_images', 'type=plupload_image&size=full' );
            foreach ( $images as $image ) :
        ?>
            <div class="scroller_item">
            <?php $scale = 156/$image['width']; ?>
                <!--<img src="<?php echo $image['url']; ?>" width="156" height="<?php echo $image['height'] * $scale; ?>" />-->
                <img src="<?php echo $image['url']; ?>" />
                <div class="data">
                    <div class="img_width">156</div>
                    <div class="img_height"><?php echo $image['height'] * $scale; ?></div>
                    <div class="img_caption"><?php echo __( $image['caption'] ); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>

<!-- The recipe -->
    <div id="recipe">
        <div class="column1">
            <h2>Information</h2>
            <p>
                Servings: <?php
                            $to_echo = __( rwmb_meta( 'recipe_servings' ) );
                            $servings = rwmb_meta( 'recipe_serving_size' );
                            if ( $servings != '' ) {
                                $to_echo .= __( $servings ).' servings';
                            }

                            echo $to_echo
                        ?><br />
                Time: <?php echo __( rwmb_meta( 'recipe_time' ) )?><br />
                Price: <?php echo __( rwmb_meta( 'recipe_price' ) )?><br />
                Nutrition <?php
                            $servings = rwmb_meta( 'recipe_serving_size' );
                            if ( $servings != '' ) {
                                echo '(per '.__( $servings ).' serving)';
                            } else {
                                echo '(per serving)';
                            }
                            ?>: <br />
                Calories: <?php echo __( rwmb_meta( 'recipe_calories' ) )?><br />
                Protein: <?php echo __( rwmb_meta( 'recipe_protein' ) )?><br />
                Fat: <?php echo __( rwmb_meta( 'recipe_fat' ) )?><br />
                Saturated fat: <?php echo __( rwmb_meta( 'recipe_saturated_fat' ) )?><br />
                Carbohydrates: <?php echo __( rwmb_meta( 'recipe_carbohydrates' ) )?><br />
                Fiber: <?php echo __( rwmb_meta( 'recipe_fiber' ) )?><br />
                Sodium: <?php echo __( rwmb_meta( 'recipe_sodium' ) )?><br />
                Cholesterol:  <?php echo __( rwmb_meta( 'recipe_cholesterol' ) )?><br />
            </p>
        </div>
        <div class="column2">
            <h2>Ingredients</h2>
            <?php echo rwmb_meta( 'recipe_ingredients' ) ?>
        </div>
        <div class="column3">
            <h2>Preparation</h2>
            <?php echo rwmb_meta( 'recipe_preperation' ); ?>
            <!--
            <ol>
                <?php
                //$content = '';
                //$preperation_steps = rwmb_meta( 'recipe_preperation' );
                
                //foreach ( $preperation_steps as $preperation_step )
                //{
                //    $content .='<li>'.$preperation_step.'</li>';
                //}

                //echo $content;
                ?>
            </ol>
            -->
        </div>
    </div>

<!-- Links to share the recipe -->
    <div id="share">
        <div class="column1">
            <!-- Facebook -->
            <div class="fb-like" data-href="<?php echo get_permalink($post->ID); ?>" data-colorscheme="light" data-layout="button_count" data-action="like" data-show-faces="false" data-send="false"></div>

            <!-- Place this tag where you want the +1 button to render. 
            <div class="g-plusone" data-size="medium" data-href="<?php echo get_permalink($post->ID); ?>"></div>-->

            <!-- Place this tag after the last +1 button tag. 
            <script type="text/javascript">
              (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
              })();
            </script>-->

            <!-- Twitter -->
            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo get_permalink($post->ID); ?>">Tweet</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
            
        </div>
        <div class="column2">
            <div id="print_it">
                <script language="JavaScript">
                    if (window.print) {
                        document.write('<form> '
                            + '<input type=\"image\" src=\"<?php echo get_template_directory_uri()."/images/icon_print.png" ?>\" name=\"print\" '
                            + 'onClick="javascript:window.print()" title="Print this recipe"></form>');
                    }
                </script>
            </div>
            <div id="email_it">
                <?php
                    $the_subject = 'A Recipe From Vegetarianized.com: '.get_the_title($post->ID);
                    $the_body = get_the_title($post->ID).
                                '%0A%0A'.
                                substr(substr(rtrim(ltrim(rwmb_meta( 'recipe_description' ))), 3), 0, -4).
                                '%0A%0A'.
                                'See the full recipe here:'.'%0A'.
                                get_permalink($post->ID);
                ?>
                <a href="mailto:?subject=<?php echo $the_subject; ?>&amp;body=<?php echo esc_html($the_body); ?>" title="Email this recipe"><img src="<?php echo get_template_directory_uri().'/images/icon_email.png' ?>" /></a>
            </div>
        </div>
    </div>

<?php // add the comments section
    if ( is_front_page() ) {
        global $withcomments;
        $withcomments = true;
        comments_template( '', true );
    } else {
        comments_template( '', true );
    }
?>

<?php
    if ( !is_front_page() ) {
        get_footer();
    }
?>
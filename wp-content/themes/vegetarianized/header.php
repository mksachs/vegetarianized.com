<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till the page content starts
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <title><?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : wp_title(''); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="icon" type="image/png" href="<?php echo esc_url( home_url( '/' ) ); ?>/apple-touch-icon.png" />
    <link rel="shortcut icon" href="http://www.vegetarianized.com/favicon.ico?v=2" />
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php  
global $brand_name; 
$logo_image =  get_template_directory_uri()."/images/vegetarianized_logo_".$brand_name.".png";
$logo_print_image =  get_template_directory_uri()."/images/vegetarianized_logo_".$brand_name."_print.png";
?>

<div id="uber">
    <div id="print_logo"><object type="image/svg+xml" width="192" height="32" data="<?php echo $logo_print_image ?>">Your browser does not support SVG</object></div>
    <div id="header">
        <div id="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $logo_image ?>" /></a></div>
        <div id="header-social"><?php echo do_shortcode("[shareaholic app='follow_buttons' id='7527394']"); ?></div>
        <!--<div id="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" /></a></div>-->
        <div id="navigation">
            <div class="nav_item">
                <?php
                    $about_page = get_page_by_title('About');
                    $about_page_link = get_permalink($about_page->ID);
                ?><a href="<?php echo $about_page_link ?>">About</a>
            </div>
            <div class="nav_item">
                <?php
                    $press_page = get_page_by_title('Press');
                    $press_page_link = get_permalink($press_page->ID);
                ?><a href="<?php echo $press_page_link ?>">Press</a>
            </div>
            <div class="nav_item">
                Search
                <div class="nav_sub_item">
                    <?php get_search_form(); ?>
                </div>
            </div>
            <div class="nav_item">
                Subscribe
                <div class="nav_sub_item">
                    <?php echo do_shortcode("[wysija_form id=\"3\"]"); ?>
                </div>
            </div>

            <!--
            <div class="nav_item">
                Social Media
                <div class="nav_sub_item">
                    <ul>
                        <?php
                            if ( is_user_logged_in() ) {
                                echo '<li class="following">';
                            } else {
                                echo '<li>';
                            }
                        ?>
                            <div class="email_follow"> <!~~ #widget ~~>
                                <div class="email_follow_button"> <!~~ .btn-o ~~>
                                    <?php
                                        if ( is_front_page() ) {
                                            $login_redirect = home_url( '/' );
                                        } else {
                                            $login_redirect = get_permalink();
                                        } 
                                        if ( is_user_logged_in() ) {
                                            $a_title = 'You are signed up for Vegetarianized.com recipes';
                                            $img_src = get_template_directory_uri().'/images/email_follow_active.png';
                                            $a_href = esc_url( wp_logout_url( $login_redirect ) );
                                        } else {
                                            $a_title = 'Sign up for Vegetarianized.com recipes';
                                            $img_src = get_template_directory_uri().'/images/email_follow.png';
                                            $a_href = esc_url( wp_login_url( $login_redirect ) );
                                        }
                                        echo '<a class="button" title="'.$a_title.'" href="'.$a_href.'"> <!~~ #follow-button .btn ~~>';
                                        echo '  <img src="'.$img_src.'" /> <!~~ i ~~>';
                                    ?>
                                        <span class="label">Subscribe</span>
                                    </a>
                                </div>
                                <div class="email_follow_count"> <!~~ #c .count-o ~~>
                                    <i></i>
                                    <u></u>
                                    <a class="note" href=""> <!~~ #count ~~>
                                        <?php
                                            $result = count_users();
                                            echo $result['total_users'].' subscribers';
                                        ?>
                                    </a>
                                </div>
                            </div>
                        <!~~<a href="<?php echo wp_login_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/email_follow.png" /></a></li>~~>
                        <!~~
                        <li><div class="fb-follow" data-href="http://www.facebook.com/vegetarianized" data-colorscheme="light" data-layout="button_count" data-show-faces="false"></div></li>
                        ~~>
                        <!~~
                        <li><a href="https://twitter.com/Vegetarianized" class="twitter-follow-button" data-show-count="true" data-show-screen-name="false" data-dnt="true">Follow @Vegetarianized</a>
                            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                        </li>
                        ~~>
                        <li>
                        <?php echo do_shortcode("[shareaholic app='follow_buttons' id='7527394']"); ?>
                        </li>

                    </ul>
                </div>
            </div>
            -->
            <div class="nav_item">
                <?php
                    $why_page = get_page_by_title('Why');
                    $why_page_link = get_permalink($why_page->ID);
                ?><a href="<?php echo $why_page_link ?>">Why</a>
            </div>
            <div class="nav_item">
                Recipes
                <div class="nav_sub_item">
                    <ul>
                        <?php wp_list_categories('show_count=1&title_li=&exclude=1'); ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>



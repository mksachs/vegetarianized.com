<?php
/* 
Plugin Name: WordPress Post Analytics
Plugin URI: http://wisdmlabs.com
Version: 1.1
Author: <a href="http://www.wisdmlabs.com">WisdmLabs</a>
Description: Let your visitors know how popular your posts are!

Copyright 2012  Wisdmlabs 

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/ 
add_option ('savecolorvalue');
if (!class_exists("DevloungePluginSeries")) {
	class DevloungePluginSeries {
		var $adminOptionsName = "DevloungePluginSeriesAdminOptions";
		function DevloungePluginSeries() { //constructor
			
		}
		function init() {
			$this->getAdminOptions();
		}
		//Returns an array of admin options
		function getAdminOptions() {
			$devloungeAdminOptions = array('show_header' => 'true',
				'add_content' => 'true', 
				'comment_author' => 'true', 
				'content' => '',
				 'trending'=>'' , 'email_id'=>'','ga-pass'=>'','profile_id'=>''      );
			$devOptions = get_option($this->adminOptionsName);
			if (!empty($devOptions)) {
				foreach ($devOptions as $key => $option)
					$devloungeAdminOptions[$key] = $option;
			}				
			update_option($this->adminOptionsName, $devloungeAdminOptions);
			return $devloungeAdminOptions;
		}
		
		function addHeaderCode() {
			$devOptions = $this->getAdminOptions();
			if ($devOptions['show_header'] == "false") { return; }
			?>
<!-- Devlounge Was Here -->
			<?php
		
		}
		
		
		//Prints out the admin page
		function printAdminPage() {
		         $valmail=true;
				 $valpid=true; 
					$devOptions = $this->getAdminOptions();
										
					if (isset($_POST['update_devloungePluginSeriesSettings'])) { 
						
					 switch($_POST['colorversion']){
						case 'Dark':
               update_option ('savecolorvalue' , 'dark');
               break;
            case 'Light':
               update_option ('savecolorvalue' , 'light');
               break;
         }	

                                    if (isset($_POST['email_id'])) {
									
									if (is_valid_email($_POST['email_id']))
									{
							$devOptions['email_id'] = apply_filters('content_save_pre', $_POST['email_id']);
						           $valmail=true;
								   }
							 else
							 {
							 $devOptions['email_id']="";
                              $valmail=false;							 
                              }							 
						}

                                          if (isset($_POST['ga-pass'])) {
							$devOptions['ga-pass'] = apply_filters('content_save_pre', $_POST['ga-pass']);
						}

                                            if (isset($_POST['profile_id'])) {
									$num = $_POST['profile_id'];	
								if ( (int)$num == $num && (int)$num > 0 )
		                {
											
				$devOptions['profile_id'] = apply_filters('content_save_pre', $_POST['profile_id']);
						             $valpid=true;
			}
									
									
									else
							 {
							 $devOptions['profile_id']="";
                              $valpid=false;							 
                              }		
						}







						update_option($this->adminOptionsName, $devOptions);
                                                
						
                                               update_option('email_id',$devOptions['email_id']);
                                               update_option('ga-pass',$devOptions['ga-pass']);
                                               update_option('profile_id',$devOptions['profile_id']);
                          if($valmail==false)
                          {
                           						  
						?>
<div class="updated" style="border-color:red"><p><strong><?php _e("Enter Correct Email", "DevloungePluginSeries");?></strong></p></div>
						<?php } 
						
						else if($valpid==false)
                          {
                           						  
						?>
<div class="updated" style="border-color:red"><p><strong><?php _e("Profile Id should be Numeric", "DevloungePluginSeries");?></strong></p></div>
						<?php } 
						
						else {?>
<div class="updated"><p><strong><?php _e("Settings Updated.", "DevloungePluginSeries");?></strong></p></div>
					<?php }
					} ?>
<style type="text/css" media="screen">
		
			
			* { margin: 0; padding: 0; }
			 #sumit ul li { display: inline; }
			
			.wide {
				border-bottom: 1px #000 solid;
				width: auto;
			}
			
			.fleft { float: left; margin: 0 20px 0 0; }
			
			.cboth { clear: both; }
			.pp_social{ display:none;}
			
			.gallery img {display:none;}

div.pp_default .pp_top,div.pp_default .pp_top .pp_middle,div.pp_default .pp_top .pp_left,div.pp_default .pp_top .pp_right,div.pp_default .pp_bottom,div.pp_default .pp_bottom .pp_left,div.pp_default .pp_bottom .pp_middle,div.pp_default .pp_bottom .pp_right{height:13px}
div.pp_default .pp_top .pp_left{background:url(../images/prettyPhoto/default/sprite.png) -78px -93px no-repeat}
div.pp_default .pp_top .pp_middle{background:url(../images/prettyPhoto/default/sprite_x.png) top left repeat-x}
div.pp_default .pp_top .pp_right{background:url(../images/prettyPhoto/default/sprite.png) -112px -93px no-repeat}
div.pp_default .pp_content .ppt{color:#f8f8f8}
div.pp_default .pp_content_container .pp_left{background:url(../images/prettyPhoto/default/sprite_y.png) -7px 0 repeat-y;padding-left:13px}
div.pp_default .pp_content_container .pp_right{background:url(../images/prettyPhoto/default/sprite_y.png) top right repeat-y;padding-right:13px}
div.pp_default .pp_next:hover{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/default/sprite_next.png") center right no-repeat;cursor:pointer}
div.pp_default .pp_previous:hover{background:url(../images/prettyPhoto/default/sprite_prev.png) center left no-repeat;cursor:pointer}
div.pp_default .pp_expand{background:url(../images/prettyPhoto/default/sprite.png) 0 -29px no-repeat;cursor:pointer;width:28px;height:28px}
div.pp_default .pp_expand:hover{background:url(../images/prettyPhoto/default/sprite.png) 0 -56px no-repeat;cursor:pointer}
div.pp_default .pp_contract{background:url(../images/prettyPhoto/default/sprite.png) 0 -84px no-repeat;cursor:pointer;width:28px;height:28px}
div.pp_default .pp_contract:hover{background:url(../images/prettyPhoto/default/sprite.png) 0 -113px no-repeat;cursor:pointer}
div.pp_default .pp_close{width:30px;height:30px;background:url(../images/prettyPhoto/default/sprite.png) 2px 1px no-repeat;cursor:pointer}
div.pp_default .pp_gallery ul li a{background:url(../images/prettyPhoto/default/default_thumb.png) center center #f8f8f8;border:1px solid #aaa}
div.pp_default .pp_social{margin-top:7px}
div.pp_default .pp_gallery a.pp_arrow_previous,div.pp_default .pp_gallery a.pp_arrow_next{position:static;left:auto}
div.pp_default .pp_nav .pp_play,div.pp_default .pp_nav .pp_pause{background:url(../images/prettyPhoto/default/sprite.png) -51px 1px no-repeat;height:30px;width:30px}
div.pp_default .pp_nav .pp_pause{background-position:-51px -29px}
div.pp_default a.pp_arrow_previous,div.pp_default a.pp_arrow_next{background:url(../images/prettyPhoto/default/sprite.png) -31px -3px no-repeat;height:20px;width:20px;margin:4px 0 0}
div.pp_default a.pp_arrow_next{left:52px;background-position:-82px -3px}
div.pp_default .pp_content_container .pp_details{margin-top:5px}
div.pp_default .pp_nav{clear:none;height:30px;width:110px;position:relative}
div.pp_default .pp_nav .currentTextHolder{font-family:Georgia;font-style:italic;color:#999;font-size:11px;left:75px;line-height:25px;position:absolute;top:2px;margin:0;padding:0 0 0 10px}
div.pp_default .pp_close:hover,div.pp_default .pp_nav .pp_play:hover,div.pp_default .pp_nav .pp_pause:hover,div.pp_default .pp_arrow_next:hover,div.pp_default .pp_arrow_previous:hover{opacity:0.7}
div.pp_default .pp_description{font-size:11px;font-weight:700;line-height:14px;margin:5px 50px 5px 0}
div.pp_default .pp_bottom .pp_left{background:url(../images/prettyPhoto/default/sprite.png) -78px -127px no-repeat}
div.pp_default .pp_bottom .pp_middle{background:url(../images/prettyPhoto/default/sprite_x.png) bottom left repeat-x}
div.pp_default .pp_bottom .pp_right{background:url(../images/prettyPhoto/default/sprite.png) -112px -127px no-repeat}
div.pp_default .pp_loaderIcon{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/default/loader.gif") center center no-repeat}
div.light_rounded .pp_top .pp_left{background:url(../images/prettyPhoto/light_rounded/sprite.png) -88px -53px no-repeat}
div.light_rounded .pp_top .pp_right{background:url(../images/prettyPhoto/light_rounded/sprite.png) -110px -53px no-repeat}
div.light_rounded .pp_next:hover{background:url(../images/prettyPhoto/light_rounded/btnNext.png) center right no-repeat;cursor:pointer}
div.light_rounded .pp_previous:hover{background:url(../images/prettyPhoto/light_rounded/btnPrevious.png) center left no-repeat;cursor:pointer}
div.light_rounded .pp_expand{background:url(../images/prettyPhoto/light_rounded/sprite.png) -31px -26px no-repeat;cursor:pointer}
div.light_rounded .pp_expand:hover{background:url(../images/prettyPhoto/light_rounded/sprite.png) -31px -47px no-repeat;cursor:pointer}
div.light_rounded .pp_contract{background:url(../images/prettyPhoto/light_rounded/sprite.png) 0 -26px no-repeat;cursor:pointer}
div.light_rounded .pp_contract:hover{background:url(../images/prettyPhoto/light_rounded/sprite.png) 0 -47px no-repeat;cursor:pointer}
div.light_rounded .pp_close{width:75px;height:22px;background:url(../images/prettyPhoto/light_rounded/sprite.png) -1px -1px no-repeat;cursor:pointer}
div.light_rounded .pp_nav .pp_play{background:url(../images/prettyPhoto/light_rounded/sprite.png) -1px -100px no-repeat;height:15px;width:14px}
div.light_rounded .pp_nav .pp_pause{background:url(../images/prettyPhoto/light_rounded/sprite.png) -24px -100px no-repeat;height:15px;width:14px}
div.light_rounded .pp_arrow_previous{background:url(../images/prettyPhoto/light_rounded/sprite.png) 0 -71px no-repeat}
div.light_rounded .pp_arrow_next{background:url(../images/prettyPhoto/light_rounded/sprite.png) -22px -71px no-repeat}
div.light_rounded .pp_bottom .pp_left{background:url(../images/prettyPhoto/light_rounded/sprite.png) -88px -80px no-repeat}
div.light_rounded .pp_bottom .pp_right{background:url(../images/prettyPhoto/light_rounded/sprite.png) -110px -80px no-repeat}
div.dark_rounded .pp_top .pp_left{background:url(../images/prettyPhoto/dark_rounded/sprite.png) -88px -53px no-repeat}
div.dark_rounded .pp_top .pp_right{background:url(../images/prettyPhoto/dark_rounded/sprite.png) -110px -53px no-repeat}
div.dark_rounded .pp_content_container .pp_left{background:url(../images/prettyPhoto/dark_rounded/contentPattern.png) top left repeat-y}
div.dark_rounded .pp_content_container .pp_right{background:url(../images/prettyPhoto/dark_rounded/contentPattern.png) top right repeat-y}
div.dark_rounded .pp_next:hover{background:url(../images/prettyPhoto/dark_rounded/btnNext.png) center right no-repeat;cursor:pointer}
div.dark_rounded .pp_previous:hover{background:url(../images/prettyPhoto/dark_rounded/btnPrevious.png) center left no-repeat;cursor:pointer}
div.dark_rounded .pp_expand{background:url(../images/prettyPhoto/dark_rounded/sprite.png) -31px -26px no-repeat;cursor:pointer}
div.dark_rounded .pp_expand:hover{background:url(../images/prettyPhoto/dark_rounded/sprite.png) -31px -47px no-repeat;cursor:pointer}
div.dark_rounded .pp_contract{background:url(../images/prettyPhoto/dark_rounded/sprite.png) 0 -26px no-repeat;cursor:pointer}
div.dark_rounded .pp_contract:hover{background:url(../images/prettyPhoto/dark_rounded/sprite.png) 0 -47px no-repeat;cursor:pointer}
div.dark_rounded .pp_close{width:75px;height:22px;background:url(../images/prettyPhoto/dark_rounded/sprite.png) -1px -1px no-repeat;cursor:pointer}
div.dark_rounded .pp_description{margin-right:85px;color:#fff}
div.dark_rounded .pp_nav .pp_play{background:url(../images/prettyPhoto/dark_rounded/sprite.png) -1px -100px no-repeat;height:15px;width:14px}
div.dark_rounded .pp_nav .pp_pause{background:url(../images/prettyPhoto/dark_rounded/sprite.png) -24px -100px no-repeat;height:15px;width:14px}
div.dark_rounded .pp_arrow_previous{background:url(../images/prettyPhoto/dark_rounded/sprite.png) 0 -71px no-repeat}
div.dark_rounded .pp_arrow_next{background:url(../images/prettyPhoto/dark_rounded/sprite.png) -22px -71px no-repeat}
div.dark_rounded .pp_bottom .pp_left{background:url(../images/prettyPhoto/dark_rounded/sprite.png) -88px -80px no-repeat}
div.dark_rounded .pp_bottom .pp_right{background:url(../images/prettyPhoto/dark_rounded/sprite.png) -110px -80px no-repeat}
div.dark_rounded .pp_loaderIcon{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/dark_rounded/loader.gif") center center no-repeat}
div.dark_square .pp_left,div.dark_square .pp_middle,div.dark_square .pp_right,div.dark_square .pp_content{background:#000}
div.dark_square .pp_description{color:#fff;margin:0 85px 0 0}
div.dark_square .pp_loaderIcon{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/dark_square/loader.gif") center center no-repeat}
div.dark_square .pp_expand{background:url(../images/prettyPhoto/dark_square/sprite.png) -31px -26px no-repeat;cursor:pointer}
div.dark_square .pp_expand:hover{background:url(../images/prettyPhoto/dark_square/sprite.png) -31px -47px no-repeat;cursor:pointer}
div.dark_square .pp_contract{background:url(../images/prettyPhoto/dark_square/sprite.png) 0 -26px no-repeat;cursor:pointer}
div.dark_square .pp_contract:hover{background:url(../images/prettyPhoto/dark_square/sprite.png) 0 -47px no-repeat;cursor:pointer}
div.dark_square .pp_close{width:75px;height:22px;background:url(../images/prettyPhoto/dark_square/sprite.png) -1px -1px no-repeat;cursor:pointer}
div.dark_square .pp_nav{clear:none}
div.dark_square .pp_nav .pp_play{background:url(../images/prettyPhoto/dark_square/sprite.png) -1px -100px no-repeat;height:15px;width:14px}
div.dark_square .pp_nav .pp_pause{background:url(../images/prettyPhoto/dark_square/sprite.png) -24px -100px no-repeat;height:15px;width:14px}
div.dark_square .pp_arrow_previous{background:url(../images/prettyPhoto/dark_square/sprite.png) 0 -71px no-repeat}
div.dark_square .pp_arrow_next{background:url(../images/prettyPhoto/dark_square/sprite.png) -22px -71px no-repeat}
div.dark_square .pp_next:hover{background:url(../images/prettyPhoto/dark_square/btnNext.png) center right no-repeat;cursor:pointer}
div.dark_square .pp_previous:hover{background:url(../images/prettyPhoto/dark_square/btnPrevious.png) center left no-repeat;cursor:pointer}
div.light_square .pp_expand{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/sprite.png") -31px -26px no-repeat;cursor:pointer}
div.light_square .pp_expand:hover{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/sprite.png") -31px -47px no-repeat;cursor:pointer}
div.light_square .pp_contract{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/sprite.png") 0 -26px no-repeat;cursor:pointer}
div.light_square .pp_contract:hover{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/sprite.png") 0 -47px no-repeat;cursor:pointer}
div.light_square .pp_close{width:75px;height:22px;background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/sprite.png") -1px -1px no-repeat;cursor:pointer}
div.light_square .pp_nav .pp_play{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/sprite.png") -1px -100px no-repeat;height:15px;width:14px}
div.light_square .pp_nav .pp_pause{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/sprite.png") -24px -100px no-repeat;height:15px;width:14px}
div.light_square .pp_arrow_previous{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/sprite.png") 0 -71px no-repeat}
div.light_square .pp_arrow_next{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/sprite.png") -22px -71px no-repeat}
div.light_square .pp_next:hover{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/btnNext.png") center right no-repeat;cursor:pointer}
div.light_square .pp_previous:hover{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_square/btnPrevious.png") center left no-repeat;cursor:pointer}

div.pp_pic_holder a:focus{outline:none}
div.pp_overlay{background:#000;display:none;left:0;position:absolute;top:0;width:100%;z-index:9500}
div.pp_pic_holder{display:none;position:absolute;width:100px;z-index:10000}
.pp_content{height:40px;min-width:40px}
* html .pp_content{width:40px}
.pp_content_container{position:relative;text-align:left;width:100%}
.pp_content_container .pp_left{padding-left:20px}
.pp_content_container .pp_right{padding-right:20px}
.pp_content_container .pp_details{float:left;margin:10px 0 2px}
.pp_description{display:none;margin:0}
.pp_social{float:left;margin:0}
.pp_social .facebook{float:left;margin-left:5px;width:55px;overflow:hidden}
.pp_social .twitter{float:left}
.pp_nav{clear:right;float:left;margin:3px 10px 0 0}
.pp_nav p{float:left;white-space:nowrap;margin:2px 4px}
.pp_nav .pp_play,.pp_nav .pp_pause{float:left;margin-right:4px;text-indent:-10000px}
a.pp_arrow_previous,a.pp_arrow_next{display:block;float:left;height:15px;margin-top:3px;overflow:hidden;text-indent:-10000px;width:14px}
.pp_hoverContainer{position:absolute;top:0;width:100%;z-index:2000}
.pp_gallery{display:none;left:50%;margin-top:-50px;position:absolute;z-index:10000}
.pp_gallery div{float:left;overflow:hidden;position:relative}
.pp_gallery ul{float:left;height:35px;position:relative;white-space:nowrap;margin:0 0 0 5px;padding:0}
.pp_gallery ul a{border:1px rgba(0,0,0,0.5) solid;display:block;float:left;height:33px;overflow:hidden}
.pp_gallery ul a img{border:0}
.pp_gallery li{display:block;float:left;margin:0 5px 0 0;padding:0}
.pp_gallery li.default a{background:url(../images/prettyPhoto/facebook/default_thumbnail.gif) 0 0 no-repeat;display:block;height:33px;width:50px}
.pp_gallery .pp_arrow_previous,.pp_gallery .pp_arrow_next{margin-top:7px!important}
a.pp_next{background:url(../images/prettyPhoto/light_rounded/btnNext.png) 10000px 10000px no-repeat;display:block;float:right;height:100%;text-indent:-10000px;width:49%}
a.pp_previous{background:url(../images/prettyPhoto/light_rounded/btnNext.png) 10000px 10000px no-repeat;display:block;float:left;height:100%;text-indent:-10000px;width:49%}
a.pp_expand,a.pp_contract{cursor:pointer;display:none;height:20px;position:absolute;right:30px;text-indent:-10000px;top:10px;width:20px;z-index:20000}
a.pp_close{position:absolute;right:0;top:0;display:block;line-height:22px;text-indent:-10000px}
.pp_loaderIcon{display:block;height:24px;left:50%;position:absolute;top:50%;width:24px;margin:-12px 0 0 -12px}
#pp_full_res{line-height:1!important}
#pp_full_res .pp_inline{text-align:left}
#pp_full_res .pp_inline p{margin:0 0 15px}
div.ppt{color:#fff;display:none;font-size:17px;z-index:9999;margin:0 0 5px 15px}
div.pp_default .pp_content,div.light_rounded .pp_content{background-color:#fff}
div.pp_default #pp_full_res .pp_inline,div.light_rounded .pp_content .ppt,div.light_rounded #pp_full_res .pp_inline,div.light_square .pp_content .ppt,div.light_square #pp_full_res .pp_inline,div.facebook .pp_content .ppt,div.facebook #pp_full_res .pp_inline{color:#000}
div.pp_default .pp_gallery ul li a:hover,div.pp_default .pp_gallery ul li.selected a,.pp_gallery ul a:hover,.pp_gallery li.selected a{border-color:#fff}
div.pp_default .pp_details,div.light_rounded .pp_details,div.dark_rounded .pp_details,div.dark_square .pp_details,div.light_square .pp_details,div.facebook .pp_details{position:relative}
div.light_rounded .pp_top .pp_middle,div.light_rounded .pp_content_container .pp_left,div.light_rounded .pp_content_container .pp_right,div.light_rounded .pp_bottom .pp_middle,div.light_square .pp_left,div.light_square .pp_middle,div.light_square .pp_right,div.light_square .pp_content,div.facebook .pp_content{background:#fff}
div.light_rounded .pp_description,div.light_square .pp_description{margin-right:85px}
div.light_rounded .pp_gallery a.pp_arrow_previous,div.light_rounded .pp_gallery a.pp_arrow_next,div.dark_rounded .pp_gallery a.pp_arrow_previous,div.dark_rounded .pp_gallery a.pp_arrow_next,div.dark_square .pp_gallery a.pp_arrow_previous,div.dark_square .pp_gallery a.pp_arrow_next,div.light_square .pp_gallery a.pp_arrow_previous,div.light_square .pp_gallery a.pp_arrow_next{margin-top:12px!important}
div.light_rounded .pp_arrow_previous.disabled,div.dark_rounded .pp_arrow_previous.disabled,div.dark_square .pp_arrow_previous.disabled,div.light_square .pp_arrow_previous.disabled{background-position:0 -87px;cursor:default}
div.light_rounded .pp_arrow_next.disabled,div.dark_rounded .pp_arrow_next.disabled,div.dark_square .pp_arrow_next.disabled,div.light_square .pp_arrow_next.disabled{background-position:-22px -87px;cursor:default}
div.light_rounded .pp_loaderIcon,div.light_square .pp_loaderIcon{background:url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/prettyPhoto/light_rounded/loader.gif") center center no-repeat}
div.dark_rounded .pp_top .pp_middle,div.dark_rounded .pp_content,div.dark_rounded .pp_bottom .pp_middle{background:url(../images/prettyPhoto/dark_rounded/contentPattern.png) top left repeat}
div.dark_rounded .currentTextHolder,div.dark_square .currentTextHolder{color:#c4c4c4}
div.dark_rounded #pp_full_res .pp_inline,div.dark_square #pp_full_res .pp_inline{color:#fff}
.pp_top,.pp_bottom{height:20px;position:relative}
* html .pp_top,* html .pp_bottom{padding:0 20px}
.pp_top .pp_left,.pp_bottom .pp_left{height:20px;left:0;position:absolute;width:20px}
.pp_top .pp_middle,.pp_bottom .pp_middle{height:20px;left:20px;position:absolute;right:20px}
* html .pp_top .pp_middle,* html .pp_bottom .pp_middle{left:0;position:static}
.pp_top .pp_right,.pp_bottom .pp_right{height:20px;left:auto;position:absolute;right:0;top:0;width:20px}
.pp_fade,.pp_gallery li.default a img{display:none}
			
</style>
<script src="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/js/jquery-1.6.1.min.js" type="text/javascript"></script>
<script src="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:5000, autoplay_slideshow: true});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'slow',slideshow:1000000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
			</script>
<div class=wrap>
<div><h1 style="float:left;  margin-top: 1.6%;">Post Analytics by</h1><img src="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/WisdmLabs-Logo.jpg"/>
<div style='float:right'> 
 
 <form action='https://www.paypal.com/cgi-bin/webscr' method='post'>
<input type='hidden' name='cmd' value='_donations'>
<input type='hidden' name='business' value='info@wisdmlabs.com'>
<input type='hidden' name='lc' value='IN'>
<input type='hidden' name='item_name' value='WisdmLabs'>
<input type='hidden' name='no_note' value=''>
<input type='hidden' name='currency_code' value='USD'>
<input type='hidden' name='bn' value='PP-DonationsBF:btn_donate_SM.gif:NonHostedGuest'>
<input type='image' src='https://www.paypalobjects.com/en_GB/i/btn/btn_donate_SM.gif' border='0' name='submit' alt='PayPal â The safer, easier way to pay online.'>
<img alt='' border='0' src='https://www.paypalobjects.com/en_US/i/scr/pixel.gif' width='1' height='1' />
</form>
</div>
 </div>
<form style="clear:both" method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">


<h3>Set Your Google Analytics Email Id</h3>
<input name="email_id" value="<?php _e(apply_filters('format_to_edit',$devOptions['email_id']), 'DevloungePluginSeries') ?>" />
<h3>Set Your Google Analytics Email password</h3>
<input name="ga-pass" type="password" value="<?php _e(apply_filters('format_to_edit',$devOptions['ga-pass']), 'DevloungePluginSeries') ?>" />
<h3>Set Your Google Analytics Profile Id</h3>
<div id="sumit" style="margin-top: -1%; margin-bottom: 3px; margin-left: 0.4%;">
<ul class="gallery clearfix">

				<li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/fullscreen/1-700.jpg" rel="prettyPhoto[gallery1]">How do I find My Profile ID</a></li>
				<li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/fullscreen/2-700.jpg" rel="prettyPhoto[gallery1]"></a></li>
				<li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/fullscreen/3-700.jpg" rel="prettyPhoto[gallery1]"></a></li>
				<li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/fullscreen/4-700.jpg" rel="prettyPhoto[gallery1]"></a></li>
				<li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/fullscreen/5-700.jpg" rel="prettyPhoto[gallery1]"></a></li>
				<li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/fullscreen/6-700.jpg" rel="prettyPhoto[gallery1]"></a></li>
				<li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/fullscreen/7-700.jpg" rel="prettyPhoto[gallery1]"></a></li>
			</ul>

</div>
<input name="profile_id" value="<?php _e(apply_filters('format_to_edit',$devOptions['profile_id']), 'DevloungePluginSeries') ?>" />
<h3>Set Display Color</h3>

<div style="float:left">
<input type="radio" name="colorversion" style="float:left" <?php if (get_option('savecolorvalue') == 'dark') { echo 'checked';} ?> value="Dark" /> Dark &nbsp; &nbsp; &nbsp; </div> <div><ul class="gallery clearfix">
				<li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/dark-preview.jpg" rel="prettyPhoto" />Preview</a></li>
			</ul></div><br />
<div style="float:left">
<input type="radio" name="colorversion" <?php if (get_option('savecolorvalue') == 'light') { echo 'checked';} ?> value="Light" /> Light &nbsp; &nbsp; </div> <div><ul class="gallery clearfix">
				<li><a href="<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/light-preview.jpg" rel="prettyPhoto" />Preview</a></li>
			</ul></div>

<div class="submit">
<input type="submit" name="update_devloungePluginSeriesSettings" value="<?php _e('Update Settings', 'DevloungePluginSeries') ?>" /></div>
</form>
 </div>
					<?php
				}//End function printAdminPage()
	
	}

} //End Class DevloungePluginSeries

if (class_exists("DevloungePluginSeries")) {
	$dl_pluginSeries = new DevloungePluginSeries();
}

//Initialize the admin panel
if (!function_exists("DevloungePluginSeries_ap")) {
	function DevloungePluginSeries_ap() {
		global $dl_pluginSeries;
		if (!isset($dl_pluginSeries)) {
			return;
		}
		if (function_exists('add_options_page')) {
	add_options_page('Post Analytics Settings', 'Post Analytics Settings', 9, basename(__FILE__), array(&$dl_pluginSeries, 'printAdminPage'));
		}
	}	
}

 function my_permalink() {
 
return substr(get_permalink($post->ID), strlen(get_settings('home')));


 } 
function is_valid_email($email) {
  $result = TRUE;
  if(!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$", $email)) {
    $result = FALSE;
  }
  return $result;
}



function is_unsigned_int($val) {
   return ( preg_match( '/^d*$/'  , $val) == 1 );
}


function minutes( $seconds )
{
    return sprintf( "%02.2d:%02.2d", floor( $seconds / 60 ), $seconds % 60 );
}





function ga_report()
{


define('ga_email',get_option('email_id'));
define('ga_password',get_option('ga-pass'));
define('ga_profile_id',get_option('profile_id'));

require 'gapi.class.php';

$ga = new gapi(ga_email,ga_password);
$filter = 'pagePath=='.my_permalink();
$ga->requestReportData(ga_profile_id,array('hostname','pagePath'),array('pageviews','uniquePageviews','visits','entrances','avgTimeOnPage'),'-visits',$filter);
?>
<style type="text/css">
.abc
{
<?php if (get_option('savecolorvalue') == 'light') { ?>
border-right:1.5px solid #000;
<? ;} else { ?>
border-right:1.5px solid #FFF;
<? ; } ?>
}

#mydiv {overflow: hidden; /*FF fix*/
    height: 100%;
	font-family: "Helvetica Neue",Arial,Helvetica,sans-serif; 
	<?php if (get_option('savecolorvalue') == 'light') { ?>
background: url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/pattern.png") repeat scroll 0 0%, -moz-radial-gradient(#EEEEEE, #BBBBBB) repeat scroll 0 0 transparent !important;
background: url("http://mirealux.com/directory/wp-content/plugins/wordpress-post-analytics/images/Previews/pattern.png"), -webkit-radial-gradient(#EEEEEE, #BBBBBB) repeat scroll 0 0 transparent !important;
        <? ;} else { ?>
	background: url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/pattern.png"), -webkit-radial-gradient( hsl(210, 30%, 20%), hsl(210, 30%, 0%));
	background: url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/pattern.png"),    -moz-radial-gradient( hsl(210, 30%, 20%), hsl(210, 30%, 0%));
	background: url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/pattern.png"),     -ms-radial-gradient( hsl(210, 30%, 20%), hsl(210, 30%, 0%));
	background: url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/pattern.png"),      -o-radial-gradient( hsl(210, 30%, 20%), hsl(210, 30%, 0%));
	background: url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/pattern.png"),         radial-gradient( hsl(210, 30%, 20%), hsl(210, 30%, 0%));
	<? ; } ?>
margin: 0;
	width: 83%;
	height: auto;
    text-align: center;
    
	display: -webkit-box;
	display:    -moz-box;
	display:     -ms-box;
	display:      -o-box;
	display:         box;
	
	-webkit-box-align: center;
	   -moz-box-align: center;
	    -ms-box-align: center;
	     -o-box-align: center;
	        box-align: center;
	
	-webkit-box-pack: center;
	   -moz-box-pack: center;
	    -ms-box-pack: center;
	     -o-box-pack: center;
	        box-pack: center;
	        
	-webkit-box-orient: vertical;
	   -moz-box-orient: vertical;
	    -ms-box-orient: vertical;
	     -o-box-orient: vertical;
	        box-orient: vertical;
	padding: 10px;
	/*text-align: center;*/
	box-shadow: 10px 10px 5px #888888;
	/*font-size: 20%;*/
	font-weight: bold;
        display: block;
	margin-bottom: 3%;
	border-radius: 5px 5px 5px 5px;

<?php if (get_option('savecolorvalue') == 'light') { ?>
color : #000 !important;
<? ;} if (get_option('savecolorvalue') == 'dark') { ?>
color : #FFF;
<? ;} ?>
	text-shadow: 0px 0px #FFFFFF;
	-webkit-transition: margin-left 0.3s cubic-bezier(0, 1, 0, 1);
	   -moz-transition: margin-left 0.3s cubic-bezier(0, 1, 0, 1);
	    -ms-transition: margin-left 0.3s cubic-bezier(0, 1, 0, 1);
	     -o-transition: margin-left 0.3s cubic-bezier(0, 1, 0, 1);
	        transition: margin-left 0.3s cubic-bezier(0, 1, 0, 1);
color: hsla(0,0%,0%,0);

	-webkit-perspective: 80px;
	   -moz-perspective: 30px;
	    -ms-perspective: 80px;
	     -o-perspective: 80px;
	        perspective: 80px;	
		
    }


/* #mydiv table  { margin :auto ;}*/

#mydiv th { padding-right:10px; padding-left:10px;}

.meter { 
			height: 20px;  /* Can be anything */
			position: relative;
			/*margin: 60px 0 20px 0;*/
			/*background: transparent;*/
			/*-moz-border-radius: 25px;*/
			/*-webkit-border-radius: 25px;*/
			/*border-radius: 25px;*/
			padding: 10px;
			/*-webkit-box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
			-moz-box-shadow   : inset 0 -1px 1px rgba(255,255,255,0.3);
			box-shadow        : inset 0 -1px 1px rgba(255,255,255,0.3);*/
		}
		.meter > span {
			display: block;
			height: 100%;
			   -webkit-border-top-right-radius: 8px;
			-webkit-border-bottom-right-radius: 8px;
			       -moz-border-radius-topright: 8px;
			    -moz-border-radius-bottomright: 8px;
			           border-top-right-radius: 8px;
			        border-bottom-right-radius: 8px;
			    -webkit-border-top-left-radius: 20px;
			 -webkit-border-bottom-left-radius: 20px;
			        -moz-border-radius-topleft: 20px;
			     -moz-border-radius-bottomleft: 20px;
			            border-top-left-radius: 20px;
			         border-bottom-left-radius: 20px;
			background-color: transparent;
			background-image: -webkit-gradient(
			  linear,
			  left bottom,
			  left top,
			  color-stop(0, #000033),
			  color-stop(1, #00FFFF)
			 );
			background-image: -moz-linear-gradient(
			  center bottom,
			  #000033 30%,
			  #00FFFF 95%
			 );
			-webkit-box-shadow: 
			  inset 0 2px 9px  rgba(255,255,255,0.3),
			  inset 0 -2px 6px rgba(0,0,0,0.4);
			-moz-box-shadow: 
			  inset 0 2px 9px  rgba(255,255,255,0.3),
			  inset 0 -2px 6px rgba(0,0,0,0.4);
			box-shadow: 
			  inset 0 2px 9px  rgba(255,255,255,0.3),
			  inset 0 -2px 6px rgba(0,0,0,0.4);
			position: relative;
			overflow: hidden;
		}
		.meter > span:after, .animate > span > span {
			content: "";
			position: absolute;
			top: 0; left: 0; bottom: 0; right: 0;
			background-image: 
			   -webkit-gradient(linear, 0 0, 100% 100%, 
			      color-stop(.25, rgba(255, 255, 255, .2)), 
			      color-stop(.25, transparent), color-stop(.5, transparent), 
			      color-stop(.5, rgba(255, 255, 255, .2)), 
			      color-stop(.75, rgba(255, 255, 255, .2)), 
			      color-stop(.75, transparent), to(transparent)
			   );
			background-image: 
				-moz-linear-gradient(
				  -45deg, 
			      rgba(255, 255, 255, .2) 25%, 
			      transparent 25%, 
			      transparent 50%, 
			      rgba(255, 255, 255, .2) 50%, 
			      rgba(255, 255, 255, .2) 75%, 
			      transparent 75%, 
			      transparent
			   );			
			z-index: 1;
			-webkit-background-size: 50px 50px;
			-moz-background-size: 50px 50px;
			-webkit-animation: move 60s linear infinite;
			   -webkit-border-top-right-radius: 8px;
			-webkit-border-bottom-right-radius: 8px;
			       -moz-border-radius-topright: 8px;
			    -moz-border-radius-bottomright: 8px;
			           border-top-right-radius: 8px;
			        border-bottom-right-radius: 8px;
			    -webkit-border-top-left-radius: 20px;
			 -webkit-border-bottom-left-radius: 20px;
			        -moz-border-radius-topleft: 20px;
			     -moz-border-radius-bottomleft: 20px;
			            border-top-left-radius: 20px;
			         border-bottom-left-radius: 20px;
			overflow: hidden;
		}
		
		.meter > span:after {
			display: none;
		}
#mydiv tr>:first-child {
<?php if (get_option('savecolorvalue') == 'light') { ?>
border-left:1.5px solid #000;
<? ;} if (get_option('savecolorvalue') == 'dark') { ?>
border-left:1.5px solid #FFF;
<? ;} ?>
}	
.grey.awesome, .grey.awesome:visited		{ background-color: #404040  }
	.grey.awesome:hover							{ background-color: #303030  ;}
.awesome, .awesome:visited {
	background: #222 url(/images/alert-overlay.png") repeat-x; 
	display: inline-block; 
	padding: 5px 10px 6px; 
	color: #fff;
	text-decoration: none;
	-moz-border-radius: 5px; 
	-webkit-border-radius: 5px;
	-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	-webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5);
	text-shadow: 0 -1px 1px rgba(0,0,0,0.25);
	border-bottom: 1px solid rgba(0,0,0,0.25);
	position: relative;
	cursor: pointer;
}

	.awesome:hover							{ background-color: #111; color: #fff; }
	.awesome:active							{ top: 1px; }
	.small.awesome, .small.awesome:visited 			{ font-size: 11px; padding: ; }
	.awesome, .awesome:visited,
	.medium.awesome, .medium.awesome:visited 		{ font-size: 13px; font-weight: bold; line-height: 1; text-shadow: 0 -1px 1px rgba(0,0,0,0.25); }
	.large.awesome, .large.awesome:visited 			{ font-size: 14px; padding: 8px 14px 9px; }
	
						
</style>
<script type="text/javascript">jQuery(document).ready(function() { ( function($) {$(document).ready( function() { $("input#ga-act").click(function () {$("div#mydiv").toggle('fast', function() { setTimeout( function() {$("div#progressdiv").show('fast', function() {	$(".meter > span") .each(function() {
				$(this)
					.data("origWidth", $(this).width())
					.width(0)
					.animate({
						width: $(this).data("origWidth")
					}, 3000);
				       });
 }); $(".meter > span").data("origWidth", 0);$("div#tablediv").hide(); setTimeout( function() {$("div#progressdiv").hide(); setTimeout( function() { $("div#tablediv").show();},000); }, 3005);}, 0000); });});});})( jQuery ) ;})</script>
<div id="mydiv" style="display:none; text-align:left">
<div id="progressdiv" class="meter" style="display:none"><span style="width: 100%"></span> </div>
<div id="tablediv" style="display:none">
<?php the_time('F j, Y') ?> &nbsp; To  &nbsp;<?php echo date_i18n('F j, Y', time()); ?>
<table style="margin-top: 2%;">
<tr>
  
  <th class="abc">Pageviews &nbsp;</th>
  <th class="abc">Unique Pageviews &nbsp;</th>
  <th class="abc">Visits &nbsp;</th>
  <th class="abc">Entrances&nbsp;</th>
  <th class="abc">Avg.Time on Page</th>
  
</tr>
<?php
foreach($ga->getResults() as $result):
?>
<tr>
   <td class="abc"><center><?php echo $result->getpageviews(); ?></center></td>
  <td class="abc"><center><?php echo $result->getuniquePageviews(); ?></center></td>
  <td class="abc"><center><?php echo $result->getVisits(); ?></center></td>
  <td class="abc"><center><?php echo $result->getentrances(); ?></center></td>
   <td class="abc"><center><?php $showminutes = minutes($result->getavgTimeOnPage()); echo $showminutes . '&nbsp;Mins';?></center></td>
</tr>
<?php
endforeach
?>
</table>
</div>
<div style="margin-top: 2%; font-size: 9px; font-weight:normal; text-align:right;">
Powered by Google Analytics. Brought to you by <a style="text-shadow:none; text-decoration:none;" href="http://www.wisdmlabs.com">WisdmLabs</a>
</div>
</div>
<input type="button" id="ga-act" style="cursor:pointer; color: #FFF !important; background-image: url("<?php bloginfo( 'wpurl' ); ?>/wp-content/plugins/wordpress-post-analytics/images/Previews/pattern.png");" value="Post Analytics" class="large grey awesome" />

<?php
   

}
//Actions and Filters	
if (isset($dl_pluginSeries)) {
	//Actions
	add_action('admin_menu', 'DevloungePluginSeries_ap');
	//add_action('wp_head', array(&$dl_pluginSeries, 'addHeaderCode'), 1);
	add_action('activate_devlounge-plugin-series/post-analytics.php',  array(&$dl_pluginSeries, 'init'));
	add_shortcode( 'post_analytics', 'ga_report');
	//Filters
	//add_filter('the_content', array(&$dl_pluginSeries, 'addContent'),1); 
	//add_filter('get_comment_author', array(&$dl_pluginSeries, 'authorUpperCase'));
}

?>
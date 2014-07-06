<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Vegetarianized
 * @since Vegetarianized 1.0
 */
?>

    <div id="footer">
        <div id="footer_rule"></div>
        <p>The contents of this site are the property of Vegetarianized.com and Adrienne D. Capps. All rights reserved. Please feel free to reprint verbatim any recipe or other content on Vegetarianized.com provided you do not alter the content in any way, and you cite Vegetarianized.com and provide a URL link back to the original content. Please email me with any questions: adrienne@vegetarianized.com.</p>
    </div>

<?php wp_footer(); ?>

<!-- Facebook API -->
<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '1375625889343240',                        // App ID from the app dashboard
      channelUrl : '//www.vegetarianized.com/channel.php', // Channel file for x-domain comms
      status     : true,                                 // Check Facebook Login status
      xfbml      : true                                  // Look for social plugins on the page
    });

    // Additional initialization code such as adding Event Listeners goes here
  };

  // Load the SDK asynchronously
  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/all.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>

</body>
</html>
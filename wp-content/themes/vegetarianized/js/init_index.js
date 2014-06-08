/*------------------------------------------------------------------------------
    Initializes the index page.
------------------------------------------------------------------------------*/

jQuery(document).ready(function($){
    
    // Handle mouseover events so the user knows they can click.
    function featureMouseenter(event) {
        $(event.delegateTarget).css("cursor","pointer");
    }
    function featureMouseleave(event) {
        $(event.delegateTarget).css("cursor","auto");
    }
    
    // When the feature is clicked, reveal the recipe.
    function featureClick(event) {
        // Turn off the event handlers to open the recipe.
        $("#feature").off("click");
        $(event.delegateTarget).css("cursor","auto");
        $("#feature").off("mouseenter");
        $("#feature").off("mouseleave");
        
        // We need to check if there are any alerts on the page.
        var i = 0;
        if ( $("#alerts").length != 0 ) {
            end_i = 3;
            dom_str = "#recent, #popular, #alerts";
        } else {
            end_i = 2;
            dom_str = "#recent, #popular";
        }
        
        // Fade out all of the home page elements and show the recipe.
        $(dom_str).fadeOut({duration:500, complete:function() {
            i++;
            if ( i == end_i ) {
                $("#recipe_scroller").show();
                $("#recipe").show();
                $("#comments").show();
                $("#share").show();
                
                var recipe_scroller = new Scroller("#recipe_scroller", feature);
                
                //here we make an ajax call to update the recipie views.
                //console.debug(TheAjax);
                
                var data = {
                    action: 'set_recipe_views',
                    post_id: $("#activepost").val()
                };

                // Here we make an ajax call to update the recipe views. Since
                // wp 2.8 ajaxurl is always defined in the admin header and
                // points to admin-ajax.php.
                jQuery.post(TheAjax.ajaxurl, data, function(response) {
                    // no response nessecary
                });
            }
        }});
    }
    
    // The featured recipe is on this page but we start with it hidden.
    $("#recipe_scroller").hide();
    $("#recipe").hide();
    $("#comments").hide();
    $("#share").hide();
    
    // Instantiate all of this page's clases.
    var font_sizer = new FontSizer();
    var main_nav = new Navbar("#navigation");
    var feature = new Feature("#feature");
    var recent_scroller = new Scroller("#recent");
    var popular_scroller = new Scroller("#popular");
    
    // Enable event callbacks that will reveal the recipe on this page.
    $("#feature").on("click", featureClick);
    $("#feature").on("mouseenter", featureMouseenter);
    $("#feature").on("mouseleave", featureMouseleave);
    
    /*
    // Init Facebook
    $.ajaxSetup({ cache: true });
    $.getScript('//connect.facebook.net/en_US/all/debug.js', function(){
        FB.init({
            appId       : '1375625889343240',
            channelUrl  : 'http://www.vegetarianized.com/channel.php',
            status      : true,
            xfbml       : true,
        });
        
        FB.getLoginStatus(function(response) {
          var page_id = "172101199655545";
          if (response && response.authResponse) {
            var user_id = response.authResponse.userID;
            var fql_query = "SELECT uid FROM page_fan WHERE page_id = "+page_id+"and uid="+user_id;
            FB.Data.query(fql_query).wait(function(rows) {
              if (rows.length == 1 && rows[0].uid == user_id) {
                console.log("LIKE");
                //$('#container_like').show();
              } else {
                console.log("NO LIKEY");
                //$('#container_notlike').show();
              }
            });
          } else {
            FB.login(function(response) {
              if (response && response.authResponse) {
                var user_id = response.authResponse.userID;
                var fql_query = "SELECT uid FROM page_fan WHERE page_id = "+page_id+"and uid="+user_id;
                FB.Data.query(fql_query).wait(function(rows) {
                  if (rows.length == 1 && rows[0].uid == user_id) {
                    console.log("LIKE");
                    //$('#container_like').show();
                  } else {
                    console.log("NO LIKEY");
                    //$('#container_notlike').show();
                  }
                });
              } else {
                console.log("NO LIKEY");
                //$('#container_notlike').show();
              }
            }, {scope: 'user_likes'});
          }
        });
        
        FB.Event.subscribe('edge.create', function(response) {
          console.debug('This was liked: ' + response.href);
        });
        
        FB.Event.subscribe('edge.remove', function(response) {
          console.debug('This was unliked: ' + response.href);
        });
        
        FB.Event.subscribe('auth.authResponseChange', function(response) {
          console.debug('The status of the session is: ' + response.status);
        });
    });
    */
});

/*------------------------------------------------------------------------------
    A class to control the feature area.
------------------------------------------------------------------------------*/

var Feature = Class.$extend({

/*------------------------------------------------------------------------------
    initializes the feature
------------------------------------------------------------------------------*/
__init__ : function(dom_id) {
    
    // grab the main element from the dom
    this.dom_id = dom_id;
    this.dom_jq = jQuery(this.dom_id);
    
    // there are no transitions happening
    this.in_transition = false;
    
    // this is the fade duration for all animations
    this.fade_duration = 500;
    
    // The width and height of the main feature image. This is used to fix the
    // aspect ratio of the image column of the feature. As other recipe images
    // are put in there they will be scaled to fit in this window.
    this.base_img_width = parseFloat(jQuery(this.dom_id + " > .column1 > img").attr("width"));
    this.base_img_height = parseFloat(jQuery(this.dom_id + " > .column1 > img").attr("height"));
    
    // We use these a lot so store them here.
    this.image_column = this.dom_jq.children(".column1");
    this.text_column = this.dom_jq.children(".column2");
    this.caption = this.dom_jq.children(".column2").children(".caption");
    
    // Things need to be manually resized when the window size changes
    jQuery(window).resize({$this:this}, this.resizeWindow);
    
    // Set the initial size of the elements
    this.resizeWindow();
},

/*------------------------------------------------------------------------------
    Insures all of the feature elements are scaled properly.
------------------------------------------------------------------------------*/
resizeWindow : function(event) {
    // If called from an event we need to do this to access the instance
    // properties.
    if (event)
        var $this = event.data.$this;
    else
        var $this = this;
    
    // The height of the feature image, scaled proportionally to its initial
    // height.
    feature_height = $this.image_column.width() * $this.base_img_height/$this.base_img_width;
    
    // The height of the text column
    text_height = $this.text_column.outerHeight();
    
    // If we are not in "handheld mode" (ie the window is larget than 480 pix)
    // then we set the height of the feature to be the larger of the image and
    // text column.
    if ( jQuery(window).width() > _g_screen_width_break ) {
        if ( feature_height >= text_height ) {
            $this.dom_jq.height(feature_height);
            $this.feature_ar = $this.image_column.width()/feature_height;
        } else {
            $this.dom_jq.height(text_height);
            $this.image_column.height(text_height);
            $this.feature_ar = $this.image_column.width()/text_height;
        }
    } else {
        $this.feature_ar = $this.image_column.width()/feature_height;
    }
    
    // Get the current image that is being displayed in the feature area and
    // calculate it's aspect ratio.
    curr_img = $this.image_column.children("img");
    curr_img_ar = curr_img.width()/curr_img.height();
    
    // Fit the image into the constraints defined by the initial feature image.
    if ( Math.round(curr_img_ar*1000)/1000 < Math.round($this.feature_ar*1000)/1000 ) {
        //img_height = $this.dom_jq.height();
        img_height = $this.image_column.width() * $this.base_img_height/$this.base_img_width;
        img_width = img_height*curr_img_ar;
        
    } else {
        img_width = $this.image_column.width();
        img_height = img_width/curr_img_ar;
    }
    
    // Set the image size
    curr_img.width(img_width);
    curr_img.height(img_height);

},

/*------------------------------------------------------------------------------
    The action method. This is called by the recipe scroller. It swaps the 
    feature image and the caption based upon the users selection.
------------------------------------------------------------------------------*/
action : function(event_target, callback_context, callback, callback_param) {
    // only do this if we are not in a transition already
    if ( !this.in_transition ) {
        
        // ok now we are in a transition
        this.in_transition = true;
        
        // The new image and caption. We use these a lot so store them.
        img = event_target.find("img");
        data = event_target.find(".data");
        
        // set the caption
        this.caption.html(data.children(".img_caption").html());
        
        // The current image and its position array
        curr_img = this.image_column.children("img");
        curr_img_position = curr_img.position();
        
        // The aspect ratio of the new image
        new_img_ar = parseFloat(data.children(".img_width").text())/parseFloat(data.children(".img_height").text());
        
        // Fit the image into the constraints defined by the initial feature
        // image.
        if ( Math.round(new_img_ar*1000)/1000 < Math.round(this.feature_ar*1000)/1000 ) {
            img_height = this.image_column.width() * this.base_img_height/this.base_img_width;
            img_width = img_height*new_img_ar;
            
        } else {
            img_width = this.image_column.width();
            img_height = img_width/new_img_ar;
        }
        
        // The new image element.
        new_img_str = "<img class=\"new_image\" src="+img.attr("src")+" width="+img_width+" height="+img_height+" style=\"position:absolute; top:0px; left:"+curr_img_position.left+"; z-index:0\" />";
        
        // We use a mask to prevent the annoying flash of the new image
        this.image_column.prepend("<div class=\"feature_image_bg_mask\"></div>");
        feature_img_bg_mask = this.image_column.children(".feature_image_bg_mask");
        feature_img_bg_mask.css({
            "width":this.image_column.width(),
            "height":this.dom_jq.height(),
            "position":"absolute", "top":0, "left":0,
            "padding":this.image_column.css("padding")
        });
        
        // Add the new image to the dom and grab it
        this.image_column.prepend(new_img_str);
        new_img = this.image_column.children(".new_image");
        
        // Fade out the mask and the current image
        feature_img_bg_mask.fadeOut(this.fade_duration);
        var $this = this;
        curr_img.fadeOut({duration:this.fade_duration,  complete:function() {
            // Animation complete
            jQuery(this).detach();
            feature_img_bg_mask.detach();
            $this.in_transition = false;
            new_img.css({"z-index":10,"position":"relative"});
            new_img.removeClass("new_image");
            callback.call(callback_context, callback_param);
        }});
    }
}

});
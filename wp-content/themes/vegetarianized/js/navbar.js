/*------------------------------------------------------------------------------
    A class to control the navbar.
------------------------------------------------------------------------------*/

var Navbar = Class.$extend({

/*------------------------------------------------------------------------------
    initializes the navbar
------------------------------------------------------------------------------*/
__init__ : function(dom_id) {
    
    // grab the main element from the dom
    this.dom_id = dom_id;
    this.dom_jq = jQuery(this.dom_id);
    
    // add event callbacks for the nav items
    this.dom_jq.children(".nav_item").click( {$this:this}, this.nav );
    this.dom_jq.children(".nav_item").mouseenter( {$this:this}, this.nav_item_mouseenter );
    
    // need this to access the object from within jquery loops
    var $this = this;
    
    // if there in a link in the scroller store the href and remove the link
    jQuery(this.dom_id+" > .nav_item ").each(function(index) {
        scroller_link = jQuery(this).children("a");
        if ( scroller_link.length > 0 ) {
            scroller_link.remove();
            jQuery(this).text(scroller_link.text());
            jQuery(this).data("link", scroller_link.attr("href"));
        }
    });
    
    // this is the fade duration for all animations
    this.fade_duration = 200;
    
    // nothing selected, nothing active
    this.selected_nav_item = null;
    this.active_nav_item = null;
    this.active_nav_sub_item = null;
    this.nav_active = false;
    
    // if the user clicks outside of an open nav item it will fire this method
    jQuery("html").click({$this:this}, this.clickOutside);
    
    // we need to manually reposition things if the window size changes
    jQuery(window).resize({$this:this}, this.resizeWindow);
    
},

/*------------------------------------------------------------------------------
    Removes an active nav dropdown if the user clicks outside of the item.
------------------------------------------------------------------------------*/
clickOutside : function(event) {
    // to access this instances properties
    var $this = event.data.$this;
    
    if ($this.nav_active) {
        //hide active nav
        $this.hide_nav();
    }
    
},

/*------------------------------------------------------------------------------
    If the window is resized while a nav item is active, the item needs to be
    repositioned.
------------------------------------------------------------------------------*/
resizeWindow : function(event) {
    // to access this instances properties
    var $this = event.data.$this;
    
    if ( $this.nav_active ) {
        // reposition the active nav
        $this.position_nav($this.active_nav_sub_item, $this.active_nav_item, $this.selected_nav_item);
    }
    
},

/*------------------------------------------------------------------------------
    Do the nav.
------------------------------------------------------------------------------*/
nav : function(event) {
    // make sure not to call the clickOutside method
    event.stopPropagation();
    
    // to access this instances properties
    var $this = event.data.$this;
    
    if ($this.nav_active) {
        //hide active nav
        $this.hide_nav();
    }
    
    if ( jQuery(event.delegateTarget).children(".nav_sub_item").length != 0 ) {
        //we have a sub menu
        $this.show_nav(jQuery(event.delegateTarget));
    } else {
        //just do the nav
        document.location.href = jQuery(event.delegateTarget).data("link");
    }
    
},

/*------------------------------------------------------------------------------
    Nav sub_items are all just links. This makes sure not to call the 
    clickOutside method when they are clicked.
------------------------------------------------------------------------------*/
nav_sub_item_click : function(event) {
    event.stopPropagation();
},

/*------------------------------------------------------------------------------
    Action when a nav_item is hovered over.
------------------------------------------------------------------------------*/
nav_item_mouseenter : function(event) {
    jQuery(event.delegateTarget).css("cursor","pointer");
},

/*------------------------------------------------------------------------------
    Action when a nav_item is unhovered.
------------------------------------------------------------------------------*/
nav_item_mouseleave : function(event) {
    jQuery(event.delegateTarget).css("cursor","auto");
},

/*------------------------------------------------------------------------------
    Position all of the active nav assets.
------------------------------------------------------------------------------*/
position_nav : function(active_nav_sub_item, active_nav_item, selected_nav_item) {
    // set the padding on the active nav item
    //new_top_padding = parseFloat(selected_nav_item.css("padding-top").split("px")[0]) - 1;
    new_left_padding = parseFloat(selected_nav_item.css("padding-left").split("px")[0]) - 1;
    new_right_padding = parseFloat(selected_nav_item.css("padding-right").split("px")[0]) - 1;
    active_nav_item.css({"padding-left":new_left_padding+"px", "padding-right":new_right_padding+"px"});
    
    // set the event handlers and the fades
    active_nav_item.mouseleave( {$this:this}, this.nav_item_mouseleave );
    active_nav_sub_item.mouseleave( {$this:this}, this.nav_item_mouseleave );
    active_nav_sub_item.click( {$this:this}, this.nav_sub_item_click );
    active_nav_item.fadeIn(this.fade_duration);
    active_nav_sub_item.fadeIn(this.fade_duration);
    
    // position the nav item and set the selected class
    nav_item_offset = selected_nav_item.offset();
    active_nav_item.addClass("nav_item_selected");
    active_nav_item.height(selected_nav_item.height() + 5);
    active_nav_item.css({"position":"absolute","top":nav_item_offset.top-1, "left":nav_item_offset.left});
    
    // set the border radius of the nav item
    active_nav_item_width = active_nav_item.width();
    active_nav_item_height = active_nav_item.height();
    rad_basis = 3.0;
    active_nav_item_radius_string = (rad_basis/active_nav_item_width * 100) + "% " + (rad_basis/active_nav_item_width * 100) + "% 0 0 / " + (rad_basis/active_nav_item_height * 100) + "% " + (rad_basis/active_nav_item_height * 100) + "% 0 0";
    active_nav_item.css({
        "-webkit-border-radius":active_nav_item_radius_string,
        "-moz-border-radius":active_nav_item_radius_string,
        "border-radius":active_nav_item_radius_string,
        "z-index":"52"
    });
    
    // set the sub item width and position
    active_nav_sub_item.width(selected_nav_item.children(".nav_sub_item").width() * (1.0 + 0.1));
    active_nav_sub_item.offset({
        top:nav_item_offset.top + active_nav_item.height() + parseFloat(active_nav_item.css("padding-top").split("px")[0]) + parseFloat(active_nav_item.css("padding-bottom").split("px")[0]) - 1,
        left:nav_item_offset.left - (active_nav_sub_item.width() + parseFloat(active_nav_sub_item.css("padding-right").split("px")[0]) + parseFloat(active_nav_sub_item.css("padding-left").split("px")[0])) + active_nav_item.width() + parseFloat(active_nav_item.css("padding-left").split("px")[0]) + parseFloat(active_nav_item.css("padding-right").split("px")[0])
    });
    
    // set the border radius of the sub item
    active_nav_sub_item_width = active_nav_sub_item.width();
    active_nav_sub_item_height = active_nav_sub_item.height();
    active_nav_sub_item_radius_string = (rad_basis/active_nav_sub_item_width * 100) + "% 0 " + (rad_basis/active_nav_sub_item_width * 100) + "% " + (rad_basis/active_nav_sub_item_width * 100) + "% /" + (rad_basis/active_nav_sub_item_height * 100) + "% 0 " + (rad_basis/active_nav_sub_item_height * 100) + "% " + (rad_basis/active_nav_sub_item_height * 100) + "%";
    active_nav_sub_item.css({
        "-webkit-border-radius":active_nav_sub_item_radius_string,
        "-moz-border-radius":active_nav_sub_item_radius_string,
        "border-radius":active_nav_sub_item_radius_string,
        "z-index":"51"
    });

},

/*------------------------------------------------------------------------------
    Show the nav_sub_item if there is any.
------------------------------------------------------------------------------*/
show_nav : function(selected_nav_item) {
        
        // clone the items
        active_nav_sub_item = selected_nav_item.children(".nav_sub_item").clone().appendTo("#uber");
        active_nav_item = selected_nav_item.clone().appendTo("#uber");
        
        // position the nav items
        this.position_nav(active_nav_sub_item, active_nav_item, selected_nav_item);
                
        // tell the instance that we are active
        this.selected_nav_item = selected_nav_item;
        this.active_nav_item = active_nav_item;
        this.active_nav_sub_item = active_nav_sub_item;
        this.nav_active = true;

},

/*------------------------------------------------------------------------------
    Hide the active nav.
------------------------------------------------------------------------------*/
hide_nav : function() {
    this.active_nav_item.remove();
    this.active_nav_item = null;
    this.active_nav_sub_item.remove();
    this.active_nav_sub_item = null;
    this.selected_nav_item = null;
    this.nav_active = false;
}

});
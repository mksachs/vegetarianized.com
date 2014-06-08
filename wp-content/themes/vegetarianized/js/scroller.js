/*------------------------------------------------------------------------------
    A class to control image scrollers.
------------------------------------------------------------------------------*/

var Scroller = Class.$extend({

/*------------------------------------------------------------------------------
    initializes the scroller
------------------------------------------------------------------------------*/
__init__ : function(dom_id, data_action_obj) {
    
    // grab the main element from the dom
    this.dom_id = dom_id;
    this.dom_jq = jQuery(this.dom_id);
    
    // we will also use the scroller_content sub item a lot so grab it as well
    this.content_jq = jQuery(this.dom_id+" > .scroller_content");
    
    // the callback object, if any
    this.data_action_obj = data_action_obj;
    
    // nope, its not scrolling
    this.scrolling = false;
    
    // grab some dimension we need later
    this.width = this.dom_jq.width();
    this.item_width = jQuery(this.dom_id+" > .scroller_content > .scroller_item").width();
    this.content_width = this.content_jq.width();
    
    // calculate the spacing between scroller items
    this.item_spacing = (this.content_width - 4.0*this.item_width)/3.0;
    
    // need this to access the object from within jquery loops
    var $this = this;
    
    // Set up the scroller items. Because the scroller content is positioned
    // absolutely, we need to manually set the height of the scroller. It will
    // be the height of the biggest item.
    max_item_height = 0;
    jQuery(this.dom_id+" > .scroller_content > .scroller_item").each(function(index) {
        
        // The widths of each item are set in CSS. We need to find the height
        // based on the width and the scale of the image.
        item_scale = parseFloat(jQuery(this).find(".img_height").text())/parseFloat(jQuery(this).find(".img_width").text());
        item_height = parseFloat(jQuery(this).width()) * item_scale;
        
        // We also nee the height of the item title if any
        item_text = jQuery(this).find(".scroller_item_text")
        if ( item_text.length > 0 ) {
            the_height = item_text.height() + item_height;
        } else {
            the_height = item_height;
        }
        
        // looking for the max height
        if (the_height > max_item_height)
            max_item_height = the_height;
        
        // position the scroller item
        jQuery(this).css({"position":"absolute", "top":0+"%","left":((index*($this.item_width + $this.item_spacing))/$this.content_width)*100.0+"%"});
        
        // if there in a link in the scroller store the href and remove the link
        scroller_link = jQuery(this).children(".scroller_item_text").children("a");
        //console.debug(scroller_link);
        if ( scroller_link.length > 0 ) {
            scroller_link.remove();
            jQuery(this).find(".scroller_item_text").text(scroller_link.text());
            jQuery(this).data("link", scroller_link.attr("href"));
        }
        
        // set up the event callbacks
        jQuery(this).click( {$this:$this}, $this.nav );
        jQuery(this).mouseenter( {$this:$this}, $this.scroller_item_hovered );
        jQuery(this).mouseleave( {$this:$this}, $this.scroller_item_unhovered );
        
        // track the item index
        jQuery(this).data("index", index);
        
        count = index;
    });
    
    // select the first item
    if ( this.data_action_obj != undefined ) {
        this.set_selected_item(0);
    }
    
    // Because the contents are absolutely positioned and we are using % width,
    // padding-bottom will actually set the height of the scroller. Here is a
    // description of this trick:
    // http://alistapart.com/article/creating-intrinsic-ratios-for-video
    this.content_jq.css({"padding-bottom": max_item_height/this.content_jq.width()*100.0+"%"});
    
    // If there is no title we need to supply some space at top for the page
    // indicators.
    the_title = jQuery(this.dom_id+" > h2");
    if (the_title.length == 0) {
        // need this for measuring if there are multiple pages
        if(count > 3) {
            tmp_page_indicator = jQuery("<div class=\"page_indicator\"></div>").appendTo(this.dom_id);
            page_indicator_height = tmp_page_indicator.outerHeight();
            tmp_page_indicator.remove()
        } else {
            page_indicator_height = 0
        }
        
        // add a spacer to force the extra room at the top
        this.dom_jq.prepend("<div class=\"spacer\"></div>");
        this.dom_jq.children(".spacer").css({"padding-bottom":(parseFloat(this.content_jq.css("margin-top")) + 2*page_indicator_height)/this.dom_jq.width() * 100+"%", "width":"100%"});
    }
    
    // add the scroll arrows and pagers if necessary
    this.num_pages = 1
    if(count > 3) {
        // The style of the arrow is set in the css. Here we just add the divs.
        this.dom_jq.append("<div class=\"scroller_left_arrow\"></div>");
        this.dom_jq.append("<div class=\"scroller_right_arrow\"></div>");
        
        // The top of the arrow elements should align with the top of the items.
        arrow_top = parseFloat(this.content_jq.css("margin-top")) + parseFloat(this.content_jq.css("padding-top"));
        if ( the_title.length > 0 ) {
            arrow_top += the_title.outerHeight();
        } else {
            arrow_top += parseFloat(this.dom_jq.children(".spacer").css("padding-bottom"));
        }
        
        // position the arrows
        jQuery(this.dom_id+" > .scroller_left_arrow,"+this.dom_id+" > .scroller_right_arrow").css({
            "height":parseFloat(this.content_jq.css("padding-bottom"))/this.dom_jq.height()*100.0+"%",
            "top":arrow_top/this.dom_jq.height()*100.0+"%"
        });
        
        // add the event callbacks
        jQuery(this.dom_id+" > .scroller_left_arrow,"+this.dom_id+" > .scroller_right_arrow").mouseenter( {$this:this}, this.scroller_arrow_hovered );
        jQuery(this.dom_id+" > .scroller_left_arrow,"+this.dom_id+" > .scroller_right_arrow").mouseleave({$this:this}, this.scroller_arrow_unhovered );
        jQuery(this.dom_id+" > .scroller_left_arrow,"+this.dom_id+" > .scroller_right_arrow").click( {$this:this} , this.scroll );
        
        // how many pages are there?
        this.num_pages = Math.ceil((count+1)/4);
        
        // for each page, add a pager button
        for ( i = 0; i < this.num_pages; i++ ) {
            if ( i == 0) {
                curr_item = jQuery("<div class=\"page_indicator_selected\"></div>").appendTo(this.dom_id);
            } else {
                curr_item = jQuery("<div class=\"page_indicator\"></div>").appendTo(this.dom_id);
            }
            
            // so the button knows waht page to go to
            curr_item.data("page_to",i);
            
            // position the buttons
            curr_item.css({"left":((1084 - 27 - this.num_pages*10) + i*(10))/1084 * 100.0 +"%"});
            
            // add the event callbacks
            curr_item.mouseenter({$this:this}, this.scroller_pager_hovered);
            curr_item.mouseleave({$this:this}, this.scroller_pager_unhovered);
            curr_item.click( {$this:this} , this.scroll );  
        }
    }
    
    // grab some final metrics
    // this.num_elements = count+1;
    // this.total_width = (count+1)*(this.item_width + this.item_spacing);
    this.page_width = 4.0*(this.item_width + this.item_spacing);
    this.curr_page = 0;
},

/*------------------------------------------------------------------------------
    sets the clicked item to be selected
------------------------------------------------------------------------------*/
set_selected_item : function(selected_index) {
    // need this to access the object from within jquery loops
    var $this = this;
    
    //console.debug(selected_index);
    if ( this.selected_index == undefined ) {
        // this is the first selection
        this.selected_index = selected_index;
    } else {
        // unselect the current item
        jQuery(this.dom_id+" > .scroller_content > .scroller_item").each(function(index) {
            if ( $this.selected_index == jQuery(this).data("index") ) {
                jQuery(this).find("img").css({"opacity":"1.0", "filter":"alpha(opacity=100)"});
                jQuery(this).click( {$this:$this}, $this.nav );
                jQuery(this).mouseenter( {$this:$this}, $this.scroller_item_hovered );
                jQuery(this).mouseleave( {$this:$this}, $this.scroller_item_unhovered );
            }
        });
        // set the new selection
        this.selected_index = selected_index;
    }
    
    // select the new item
    jQuery(this.dom_id+" > .scroller_content > .scroller_item").each(function(index) {
        if ( $this.selected_index == jQuery(this).data("index") ) {
            jQuery(this).find("img").css({"opacity":"0.4", "filter":"alpha(opacity=40)"});
            jQuery(this).off("click");
            jQuery(this).unbind("mouseenter");
            jQuery(this).unbind("mouseleave");
        }
    });
},

/*------------------------------------------------------------------------------
    Called when an item is clicked. It either navs to the href if one was
    supplied in the html, or it calls the action method of the callback object.
------------------------------------------------------------------------------*/
nav : function(event) {
    // to access this instances properties
    var $this = event.data.$this
    
    // if there was a link defined the nav to it
    if ( jQuery(event.delegateTarget).data("link") != undefined ) {
        document.location.href = jQuery(event.delegateTarget).data("link");
    } else {
        // No link. There should be a data action object
        if ( $this.data_action_obj != undefined ) {
            // Call the action method of the data action object. The parameters
            // are:
            //      action.call(
            //          instance being called,
            //          item clicked,
            //          context of the instance to call when the action is done,
            //          method to call when the action is done,
            //          a parameter to send to the action complete method)
            $this.data_action_obj.action.call($this.data_action_obj, jQuery(event.delegateTarget), $this, $this.set_selected_item, jQuery(event.delegateTarget).data("index"));
        } else {
            console.error("A data action object must be passed to the scroller upon initialization!");
        }
    }
},

/*------------------------------------------------------------------------------
    Action when an item is hovered over.
------------------------------------------------------------------------------*/
scroller_item_hovered : function(event) {
    // this is an event callback. to access the parent object use event.data.$this
    jQuery(event.delegateTarget).css("cursor","pointer");
},

/*------------------------------------------------------------------------------
    Action when an item is unhovered.
------------------------------------------------------------------------------*/
scroller_item_unhovered : function(event) {
    // this is an event callback. to access the parent object use event.data.$this
    jQuery(event.delegateTarget).css("cursor","auto");
},

/*------------------------------------------------------------------------------
    Action when a pager button is hovered over.
------------------------------------------------------------------------------*/
scroller_pager_hovered : function(event) {
    // this is an event callback. to access the parent object use event.data.$this
    if ( jQuery(event.delegateTarget).hasClass("page_indicator") ) {
        jQuery(event.delegateTarget).css("cursor","pointer");
        jQuery(event.delegateTarget).removeClass("page_indicator");
        jQuery(event.delegateTarget).addClass("page_indicator_hovered");
    }
},

/*------------------------------------------------------------------------------
    Action when a pager button is unhovered.
------------------------------------------------------------------------------*/
scroller_pager_unhovered : function(event) {
    // this is an event callback. to access the parent object use event.data.$this
    if ( jQuery(event.delegateTarget).hasClass("page_indicator_hovered") ) {
        jQuery(event.delegateTarget).css("cursor","auto");
        jQuery(event.delegateTarget).removeClass("page_indicator_hovered");
        jQuery(event.delegateTarget).addClass("page_indicator");
    }
},

/*------------------------------------------------------------------------------
    Action when a scroller arrow is hovered over.
------------------------------------------------------------------------------*/
scroller_arrow_hovered : function(event) {
    // this is an event callback. to access the parent object use event.data.$this
    jQuery(event.delegateTarget).css("cursor","pointer");
    jQuery(event.delegateTarget).addClass("hovered")
    //if ( jQuery(event.delegateTarget).hasClass("scroller_left_arrow") )
    //    jQuery(event.delegateTarget).children("img").attr("src","images/scroller_arrow_left_hovered.png");
    //else if ( jQuery(event.delegateTarget).hasClass("scroller_right_arrow") )
    //    jQuery(event.delegateTarget).children("img").attr("src","images/scroller_arrow_right_hovered.png");
},

/*------------------------------------------------------------------------------
    Action when a scroller arrow is hovered over.
------------------------------------------------------------------------------*/
scroller_arrow_unhovered : function(event) {
    // this is an event callback. to access the parent object use event.data.$this
    jQuery(event.delegateTarget).css("cursor","auto");
    jQuery(event.delegateTarget).removeClass("hovered");
    //if ( jQuery(event.delegateTarget).hasClass("scroller_left_arrow") )
    //    jQuery(event.delegateTarget).children("img").attr("src","images/scroller_arrow_left.png");
    //else if ( jQuery(event.delegateTarget).hasClass("scroller_right_arrow") )
    //    jQuery(event.delegateTarget).children("img").attr("src","images/scroller_arrow_right.png");
},

/*------------------------------------------------------------------------------
    This is the scrolling functionality.
------------------------------------------------------------------------------*/
scroll : function(event) {
    // to access this instances properties
    var $this = event.data.$this
    
    // only do this if the scroller is not currently scrolling
    if ( !$this.scrolling ) {
        // ok. now its scrolling
        $this.scrolling = true;
        // init a few variables
        set_end         = false;
        set_beg         = false;
        tick            = 0;
        
        if ( jQuery(event.delegateTarget).hasClass("scroller_left_arrow") ) {
            // go left
            if ( $this.curr_page == 0 ) {
                new_page = $this.num_pages - 1;
                set_end = true;
            } else {
                new_page = $this.curr_page - 1;
                tick = -1;
            }
        }
        else if ( jQuery(event.delegateTarget).hasClass("scroller_right_arrow") ) {
            // go right
            if ( $this.curr_page == $this.num_pages - 1 ) {
                new_page = 0;
                set_beg = true;
            } else {
                new_page = $this.curr_page + 1;
                tick = 1;
            }
        }
        else {
            // go to page
            new_page = jQuery(event.delegateTarget).data("page_to");
            tick = new_page - $this.curr_page;
        }
        
        if ( set_end ) {
            // move to the last page
            // save the current scroller items
            curr_scroller_items = $this.content_jq.children(".scroller_item");
            // duplicate all of the scroller items
            new_scroller_items = $this.content_jq.children(".scroller_item").clone(true, true);
            // stack them in the correct order to the left of the current set
            // scroll all items to the right
            // delete the original scroller items
            for ( i = 0; i < new_scroller_items.length; i++ ) {
                jQuery(new_scroller_items[i]).appendTo($this.content_jq);
                jQuery(new_scroller_items[i]).css({
                    "position":"absolute",
                    "top":0,
                    "left":(i*($this.item_width + $this.item_spacing) - $this.page_width * $this.num_pages)/$this.content_width * 100.0 + "%"
                });
                jQuery(new_scroller_items[i]).animate({"left":"+="+$this.page_width/$this.content_width * 100.0 + "%"},"slow",function() {
                        $this.scrolling = false;
                });
            }
            for ( i = 0; i < curr_scroller_items.length; i++ ) {
                jQuery(curr_scroller_items[i]).animate({"left":"+="+$this.page_width/$this.content_width * 100.0 + "%"},"slow",function() {
                    $this.scrolling = false;
                    jQuery(this).remove();
                });
            }
        } else if ( set_beg ) {
            // move to the first page
            // save the current scroller items
            curr_scroller_items = $this.content_jq.children(".scroller_item");
            // duplicate all of the scroller items
            new_scroller_items = $this.content_jq.children(".scroller_item").clone(true, true);
            // stack them in the correct order to the right of the current set
            // scroll all items to the left
            // delete the original scroller items
            for ( i = 0; i < new_scroller_items.length; i++ ) {
                jQuery(new_scroller_items[i]).appendTo($this.content_jq);
                jQuery(new_scroller_items[i]).css({
                    "position":"absolute",
                    "top":0,
                    "left":(i*($this.item_width + $this.item_spacing) + $this.page_width)/$this.content_width * 100.0 + "%"
                });
                jQuery(new_scroller_items[i]).animate({"left":"-="+$this.page_width/$this.content_width * 100.0 + "%"},"slow",function() {
                    $this.scrolling = false;
                });
            }
            for ( i = 0; i < curr_scroller_items.length; i++ ) {
                jQuery(curr_scroller_items[i]).animate({"left":"-="+$this.page_width/$this.content_width * 100.0 + "%"},"slow",function() {
                    $this.scrolling = false;
                    jQuery(this).remove();
                });
            }
        } else {
            // move the specified number of ticks
            if ( tick < 0 )
                $this.content_jq.children(".scroller_item").animate({"left":"+="+Math.abs(tick)*$this.page_width/$this.content_width * 100.0 + "%"},"slow",function() {
                    $this.scrolling = false;
                });
            else if (tick > 0)
                $this.content_jq.children(".scroller_item").animate({"left":"-="+Math.abs(tick)*$this.page_width/$this.content_width * 100.0 + "%"},"slow",function() {
                    $this.scrolling = false;
                });
        }
        
        // style the pagers to reflect the change
        $this.dom_jq.children(".page_indicator_selected,.page_indicator,.page_indicator_hovered").each(function(index) {
            jQuery(this).removeClass("page_indicator_selected page_indicator page_indicator_hovered");
            if ( new_page == jQuery(this).data("page_to") )
                jQuery(this).addClass("page_indicator_selected");
            else
                jQuery(this).addClass("page_indicator");   
        });
        
        // set the current page to the new page
        $this.curr_page = new_page;
    }
}

});
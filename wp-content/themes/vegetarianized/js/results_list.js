/*------------------------------------------------------------------------------
    A class to control results lists. Either search results or category 
    listings.
------------------------------------------------------------------------------*/

var ResultsList = Class.$extend({

/*------------------------------------------------------------------------------
    initializes the list
------------------------------------------------------------------------------*/
__init__ : function(dom_id) {
    this.dom_id = dom_id;
    this.dom_jq = jQuery(this.dom_id);
    
    var $this = this;
    this.dom_jq.find("li").each(function(index) {
        link_column = jQuery(this).children(".column1");
        
        jQuery(this).data("link", link_column.children("a").attr("href"));
        
        link_column.append(link_column.children("a").children("img").clone(true, true))
        
        link_column.children("a").remove();
        
        jQuery(this).on("click", {$this:$this}, $this.nav);
        jQuery(this).on("mouseenter", {$this:$this}, $this.mouseenter);
        jQuery(this).on("mouseleave", {$this:$this}, $this.mouseleave);
        
        if ( jQuery(this).find(".caption").text().length >= 600 ) {
            // truncate
            the_text = jQuery(this).find(".caption").text();
            jQuery(this).find(".caption").text(the_text.substr(0,the_text.lastIndexOf(" " ,600)) + "...");
        }
    });
},

nav : function(event) {
    console.debug(jQuery(event.delegateTarget).data("link"));
    document.location.href = jQuery(event.delegateTarget).data("link");
},

mouseenter : function(event) {
    jQuery(event.delegateTarget).css("cursor","pointer");
    jQuery(event.delegateTarget).addClass("hover");
},

mouseleave : function(event) {
    jQuery(event.delegateTarget).css("cursor","auto");
    jQuery(event.delegateTarget).removeClass("hover");
}

});
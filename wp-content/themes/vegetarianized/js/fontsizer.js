/*------------------------------------------------------------------------------
    A class to handle scaling the fonts when the window size changes.
------------------------------------------------------------------------------*/

var FontSizer = Class.$extend({

/*------------------------------------------------------------------------------
    initializes the font sizer
------------------------------------------------------------------------------*/
__init__ : function() {
    this.body = jQuery("body");
    
    // The min and max font %
    this.f_max = 100;
    this.f_min = 70;
    
    // The min and max window width
    this.w_max = 1264;
    this.w_min = 480;
    
    // Things need to be manually resized when the window size changes
    jQuery(window).resize({$this:this}, this.scale);

    // Set the initial size of the elements
    this.scale();
    
},

scale : function(event) {
    // If called from an event we need to do this to access the instance
    // properties.
    if (event)
        var $this = event.data.$this;
    else
        var $this = this;
    
    // Do the scaling.
    w = $this.body.width();
    if ( w > $this.w_max )
        f = $this.f_max;
    else if ( w < $this.w_min )
        f = $this.f_min;
    else
        f = ( ($this.f_max - $this.f_min)/($this.w_max - $this.w_min) ) * (w - $this.w_min) + $this.f_min;
    
    // Set the new scale.
    $this.body.css("font-size", f + "%");
}

});
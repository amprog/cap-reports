jQuery(document).ready(function(){

    // Wrap content between chapters
    jQuery('.chapter').each(function(index) {
        jQuery(this).attr('data-chapter', index);
        jQuery(this).nextUntil('.chapter').appendTo(this);
    });

    // Add p counter to p elements
    jQuery('p:not(:has(img))').addClass('counter-paragraph');
    jQuery('p.wp-caption-text').removeClass('counter-paragraph');
    jQuery('.oembed p').removeClass('counter-paragraph');
    jQuery('.pullquote p').removeClass('counter-paragraph');
    jQuery('blockquote > p').removeClass('counter-paragraph');

    jQuery('.twitter-tweet').wrap('<div class="tweet-offset"></div>');
    jQuery('.tweet-offset').wrap('<div class="tweet-embed"></div>');

    // // Find all instances of a full sized no aligned image and add a class to the containing paragraph.
    // jQuery( 'img.alignnone.size-full' ).each(function( index ) {
    //     // Get the parent paragraph.
    //     // First check to see if the image is wrapped in a A tag or just a P tag.
    //     var elementCheck = jQuery( this ).parent().get(0).tagName;
    //     if ( elementCheck == "A" ) {
    //         var wideA = jQuery( this ).parent().get(0).closest('p');
    //         jQuery( wideA ).addClass('wide-paragraph');
    //     } else {
    //         var wideP = jQuery( this ).parent().get(0);
    //         jQuery( wideP ).addClass('wide-paragraph');
    //     }
    // });

    jQuery('blockquote').each(function( index ) {
        if(jQuery(this).next('p:has(cite)')) {
            jQuery(this).next('p:has(cite)').css('font-size', '.8rem').detach().appendTo(this);
        }
    });

    jQuery('img.align-caption-right').each(function(index) {
        jQuery(this).parent().parent().addClass('align-caption-right');
    });

    jQuery('img.align-caption-left').each(function(index) {
        jQuery(this).parent().parent().addClass('align-caption-left');
    });

    // When we hit this screen size take the report title and such out of the cover and insert after.
    enquire.register("screen and (max-width: 700px)", {
        match : function() {
            jQuery('.report-title').insertBefore('#report-overview');
            jQuery('#report-header .time').appendTo('.report-title');
        },
        unmatch : function() {
            jQuery('.report-title').prependTo('.cpr-header-gradient');
            jQuery('.time').insertAfter('.report-title');
        }
    });

});

// Autplay video elements that are WP shortcodes.
jQuery(window).bind("load",function(){
    jQuery(function() {
        jQuery(window).scroll(function() {
            jQuery('#content:not(.hidden) .wp-video-shortcode').each(function() {
                var str = jQuery(this).attr('id');
                var arr = str.split('_');
                typecheck = arr[0];
                if (jQuery(this).is(":in-viewport( 400 )") && typecheck == "mep") {
                    mejs.players[jQuery(this).attr('id')].media.play();
                } else if (typecheck == "mep") {
                    mejs.players[jQuery(this).attr('id')].media.stop();
                }
            });
        });
    });
});

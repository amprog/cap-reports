jQuery(document).ready(function(){

    // Add p counter to p elements
    jQuery('p:not(:has(img))').addClass('counter-paragraph');
    jQuery('p.wp-caption-text').removeClass('counter-paragraph');
    jQuery('.oembed p').removeClass('counter-paragraph');
    jQuery('.ccb-pullquote p').removeClass('counter-paragraph');
    jQuery('blockquote > p').removeClass('counter-paragraph');

    jQuery('.twitter-tweet').wrap('<div class="tweet-offset"></div>');
    jQuery('.tweet-offset').wrap('<div class="tweet-embed"></div>');

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


jQuery(function() {
  jQuery('a[href*=#]:not([href=#])').click(function() {
      console.log('Trying');
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
      var target = jQuery(this.hash);
      target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
      if (target.length) {
        jQuery('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });
});

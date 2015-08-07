<?php
function get_chapter_list() {
    $markup = '<a href="javascript:void(0)" class="chapter-window-activate" style="text-decoration: none;"><i class="mdi mdi-book-multiple"></i> Chapters</a>';
    return $markup;
}

function report_toolbar($content) {
    if ( 'reports' === get_post_type() ) {
        $tools = '<div id="bottom-post-tools" class="dontlasso">';
        $tools .= '<a href="#report-header"><i class="mdi mdi-arrow-up"></i>  <span>Return to Cover</span></a> &nbsp; ';
        $tools .= get_chapter_list();
        $tools .= ' &nbsp; <i class="mdi mdi-folder-plus"></i> <span>Save Citation</span>';
        $tools .= ' &nbsp; <span id="related-content-trigger"><i class="mdi mdi-link"></i> <span>Related Content</span></span>';
        $tools .= '</div>';
        $content = $content . $tools;
    }
    return $content;
}
add_filter( 'the_content', 'report_toolbar', 1000 );

function report_share_toolbar() {
    if ( function_exists( 'sharing_display' ) && 'reports' == get_post_type() ) {
        echo '<div id="report-share-tools">';
        sharing_display( '', true );
        echo '</div>';
    }
}
add_action('wp_footer','report_share_toolbar');

function report_chapters($out) {
    if (function_exists('get_chapter_list')) {
        $additionaal_scripts = '
        jQuery("#chapter-window > div").click(function(){
            if ( jQuery("html").hasClass("locked") ) {
                jQuery("html").removeClass("locked");
            }
        });
        ';
        $out = cap_report_modal('<h2>Chapters</h2><div class="aesop-entry-header"></div>', 'chapter-window', '.chapter-window-activate', $additionaal_scripts);
        return $out;
    }
}
add_filter('aesop_chapter_menu_output', 'report_chapters');

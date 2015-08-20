<?php
function get_chapter_list() {
    $markup = '<a href="javascript:void(0)" class="chapter-window-activate" style="text-decoration: none;"><i class="mdi mdi-book-multiple"></i> Chapters</a>';
    return $markup;
}

function report_toolbar($content) {
    if ( 'reports' === get_post_type() ) {
        $tools = '<div id="bottom-post-tools">';
        $tools .= '<a href="#report-header"><i class="mdi mdi-arrow-up"></i>  <span>Return to Cover</span></a> &nbsp; ';
        $tools .= get_chapter_list();
        $tools .= '</div>';
        $content = $content . $tools;
    }
    return $content;
}
add_filter( 'the_content', 'report_toolbar', 1000 );

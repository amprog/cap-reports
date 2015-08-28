<?php
function get_chapter_list() {
    $modal_content = '<h1>Chapters:</h1><ol id="chapter-insertion"></ol>';
    $markup = '<a href="javascript:void(0)" class="chapter-window-activate" style="text-decoration: none;"><i class="mdi mdi-book-multiple"></i> Chapters</a>';
    $markup .= cap_report_modal($modal_content, 'chapter-list', '.chapter-window-activate');
    return $markup;
}

function cap_report_chapter_script() {
    ?>
    <script>
    function goto_chapter(chapter) {
        var target = jQuery('[data-chapter-title="'+chapter+'"]');
        jQuery('html,body').animate({
          scrollTop: target.offset().top
        }, 1000);
    }

    jQuery(document).ready(function($){
        var chapters = [];
        jQuery('.ccb-chapter').each(function(index) {
            chapters[index] = jQuery(this).data('chapter-title');
        });

        var list = jQuery('#chapter-list ol');

        jQuery.each(chapters, function(i) {
            var li = jQuery('<li/>')
                .appendTo(list);
            var aaa = jQuery('<a/>')
                .attr('href', 'javascript:goto_chapter("'+chapters[i]+'")')
                .text(chapters[i])
                .appendTo(li);
        });
    });
    </script>
    <?php
}
add_action('wp_footer', 'cap_report_chapter_script');

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

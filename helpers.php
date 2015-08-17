<?php
function cap_report_modal($modal_content, $modal_id, $modal_trigger_selector, $additionaal_scripts = null) {
	$markup = '
	<div id="'.$modal_id.'" class="modal">
		<div class="modal-container">
	        <a href="javascript:void(0)" class="close"><i class="mdi mdi-close-circle"></i></a>
	        <div class="modal-content">
	            '.$modal_content.'
	        </div>
		</div>
    </div>
    <script>
	jQuery("#'.$modal_id.' > div").click(function(){
    	jQuery("#'.$modal_id.'").removeClass("open");
    });
    jQuery("'.$modal_trigger_selector.'").click(function(){
        jQuery("#'.$modal_id.'").addClass("open");
    });
    jQuery("#'.$modal_id.' .close").click(function(){
        jQuery("#'.$modal_id.'").removeClass("open");
    });
	jQuery("'.$modal_trigger_selector.'").addClass("modal-trigger");
	'.$additional_scripts.'
    </script>
	';
	return $markup;
}

function cap_report_helper_oembed_filter( $html, $url, $args ) {
	$html = '<figure class="oembed" data-src="'.esc_url($url).'">' . $html . '</figure>';
    return $html;
};
// add the filter
add_filter( 'oembed_result', 'cap_report_helper_oembed_filter', 10, 3 );

function cap_report_helper_filter_scripts($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<script .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'cap_report_helper_filter_scripts');

// Turn off TinyMCE for Interactives
function disable_tinymce_interactives( $default ) {
	global $post;
	if ( 'interactive' == get_post_type( $post ) )
		return false;
	return $default;
}
add_filter( 'user_can_richedit', 'disable_tinymce_interactives' );

/**
 * Overrides some Jetpack functionality.
 */

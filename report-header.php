<?php
/**
 * Outputs the reports header along with video cover support.
 * @global by checking if the fucntion exists first we can override this on a per site basis.
 * @return the report header along with bg cover, title, and timestamp.
 */
if ( ! function_exists('cap_report_header') ) {
    function cap_report_header() {
        global $post;
        if ( 'reports' === get_post_type( $post ) ) {
            $img_width_test = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'header-cover' );
            // Does the selected image actually have the 'header-cover' size of 1440x565?
            if ( $img_width_test[1] < 1440 ) {
                $bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'header-cover' );
            // NO? Then proceed to use the full image.
            } else {
                $bg_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            }
            $bg_image_src = $bg_image[0];

            $subtitle = '';
            if (get_field('subtitle')) {
                $subtitle .= '<h4 class="cpr-entry-subtitle">'.get_field('subtitle').'</h4>';
            }
            $header_bg = 'style="background-image: url('.$bg_image_src.');"';
            // Check to see if there is a video header... if so proceed to use instead of background image.
            if(get_field('video_header')) {
                $header_bg = 'data-vide-bg="'.get_field('video_header').'"';
            }

            $header_class = 'cpr-report-featured-image cpr-report-header';
            if (get_field('static_header')) {
                $header_class .= ' static-header';
            }
            ?>
            <div id="report-header" class="<?php echo $header_class;?>" <?php echo $header_bg;?>>

                <div class="cpr-header-gradient maintain-ratio">

                    <div class="report-title">
                        <h1 class="cpr-entry-title lasso-title"><?php echo get_the_title($post->ID);?></h1>
                        <?php echo $subtitle;?>
                    </div>

                    <span class="time">Posted on <?php echo get_the_date('F j', $post->ID).'<sup>'.get_the_date('S', $post->ID).'</sup>, '.get_the_date('Y', $post->ID); ?></span>

                </div><!-- /.gradient-->

            </div>
            <?php do_action('cap_report_header_after');?>
            <?php
        }
    }
}

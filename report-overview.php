<?php
/**
 * @todo create a filter that wraps the content in a report content id and then place the header directly above that.
 */
function cap_report_overview_accordion() {
    $post = get_post( get_the_ID() );
    if (have_rows('key_points')) {
        $key_points_class = 'is-active tab-link';
        $overview_class = 'tab-link';
    } else {
        $overview_class = 'is-active tab-link';
    }
    ?>
    <div id="report-overview">
        <div class="overview-container">

            <div>
                <a href="#content" class="big-button">Read Report</a>
                <?php if( get_field('download_pdf') ) {
                    echo '<br><a href="'.get_field('download_pdf').'" class="download-pdf" download><span class="mdi mdi-file-pdf"></span> Download PDF</a>';
                } ?>
            </div>

            <ul class="accordion-tabs">

                <?php if(have_rows('key_points')):?>
                <li class="tab-header-and-content">
                    <a href="javascript:void(0)" class="<?php echo $key_points_class;?>"><h4>Key Points</h4></a>
                    <div id="key-points" class="tab-content">
                        <?php
                        while ( have_rows('key_points') ) : the_row();

                            // display a sub field value
                            echo '<aside class="key-point">';
                            the_sub_field('text');
                            echo '</aside>';

                        endwhile;
                        ?>
                    </div>
                </li>
                <?php endif;?>

                <li class="tab-header-and-content">
                    <a href="javascript:void(0)" class="<?php echo $overview_class;?>"><h4>Overview</h4></a>
                    <div class="tab-content">
                        <p><?php echo $post->post_excerpt;?></p>
                    </div>
                </li>

                <?php if(have_rows('key_takeaways')):?>
                <li class="tab-header-and-content">
                    <a href="javascript:void(0)" class="tab-link"><h4>Key Takeaways</h4></a>
                    <div id="key-takeaways" class="tab-content">
                        <?php
                        while ( have_rows('key_takeaways') ) : the_row();

                            // display a sub field value
                            echo '<aside class="takeaway shareable-text">';
                            the_sub_field('text');
                            echo '</aside>';

                        endwhile;
                        ?>
                    </div>
                </li>
                <?php endif;?>

                <li class="tab-header-and-content">
                    <a href="javascript:void(0)" class="tab-link"><h4>Related Reports</h4></a>
                    <div class="tab-content">
                        <?php related_reports();?>
                    </div>
                </li>

            </ul>
            <script>
            jQuery(document).ready(function ($) {
              jQuery('.accordion-tabs').each(function() {
                    jQuery(this).children('li').first().children('a').addClass('is-active').next().addClass('is-open').show();
              });
              jQuery('.accordion-tabs').on('click', 'li > a.tab-link', function(event) {
                if (!jQuery(this).hasClass('is-active')) {
                    event.preventDefault();
                    var accordionTabs = jQuery(this).closest('.accordion-tabs');
                    accordionTabs.find('.is-open').removeClass('is-open').hide();

                    jQuery(this).next().toggleClass('is-open').toggle();
                    accordionTabs.find('.is-active').removeClass('is-active');
                    jQuery(this).addClass('is-active');
                } else {
                    event.preventDefault();
                }
              });
            });
            </script>
        </div>
    </div>
    <?php
}
add_action('cap_report_header_after','cap_report_overview_accordion');

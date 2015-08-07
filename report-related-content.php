<?php
function related_reports() {
    $posts = array(1,2);
    ?>
    <div id="related-reports">
        <?php foreach($posts as $post) {
            $bg_image_src  = 'http://ui.lumapps.com/images/placeholder/2-horizontal.jpg';
        ?>
        <a href="#" id="postidsomething" style="background-image: url(<?php echo $bg_image_src;?>)" >
            <div>
                <label>Related Post</label>
                <h3>A post title of something here and so on</h3>
                <span class="byline">By <i class="mdi mdi-account-multiple"></i> So So and John Doe</span>
                <span class="taxonomy">In <strong>Economy</strong>, <strong>National Security</strong></span>
                <span class="date">March 25<sup>th</sup> 2015</span>
            </div>
        </a>
        <?php } ?>
    </div>
    <?php
}

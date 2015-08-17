<?php
add_action( 'init', function() {

	/**
	 * Register your shortcode as you would normally.
	 * This is a simple example for a pullquote with a citation.
	 */
	add_shortcode( 'chapter', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'title'     => '',
			'background_image' => ''
		) );

		ob_start();
        $title  = $attr['title'];
        $bg_id  = $attr['background_image'];
        $bg     = '';
        if ($bg_id) {
            $bg = wp_get_attachment_image_src( $bg_id, 'large' );
        }
		?>
		<?php do_action('cap_report_chapter_outside_before');?>
		<section class="chapter">
			<?php do_action('cap_report_chapter_inside_before');?>
			<h1 class="chapter-title"><?php echo $title;?></h1>
			<?php do_action('cap_report_chapter_inside_end');?>
		</section>
		<?php do_action('cap_report_chapter_outside_end');?>

		<?php

		return ob_get_clean();

	} );

	add_shortcode( 'pull_quote', function( $attr, $content = null ) {

		$attr = wp_parse_args( $attr, array(
			'alignment'		=> 'none',
			'source'   		=> '',
		) );

		ob_start();
        $alignment  = $attr['alignment'];
		$source = $attr['source'];
		$classes = 'pullquote'.' '.$alignment;
		?>
		<?php do_action('cap_report_pullquote_outside_before');?>
		<aside class="<?php echo $classes;?>">
			<?php do_action('cap_report_pullquote_inside_before');?>
			<p><?php echo $content;?></p>
			<span class="source"><?php echo $source;?></span>
			<?php do_action('cap_report_pullquote_inside_end');?>
		</aside>
		<?php do_action('cap_report_pullquote_outside_end');?>

		<?php

		return ob_get_clean();

	} );

	add_shortcode( 'content', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'id'		=> '',
			'style'		=> 'box',
		) );

		ob_start();
        $id 	 = $attr['id'];
		$classes = 'contentbox'.' '.$attr['style'];
		$post 	 = get_post($id);
		?>
		<?php do_action('cap_report_contentshortcode_outside_before');?>
		<aside id="content-from-<?php echo $id;?>" class="<?php echo $classes;?>">
			<?php do_action('cap_report_contentshortcode_inside_before');?>
			<div class="inner-content">
				<?php echo $post->post_content;?>
			</div>
			<?php do_action('cap_report_contentshortcode_inside_end');?>
		</aside>
		<?php do_action('cap_report_contentshortcode_outside_end');?>

		<?php

		return ob_get_clean();

	} );

	add_shortcode( 'interactive', function( $attr ) {

		$attr = wp_parse_args( $attr, array(
			'id'		=> ''
		) );

		ob_start();
        $id 	 = $attr['id'];
		$post 	 = get_post($id);
		?>
		<?php do_action('cap_report_interactiveshortcode_outside_before');?>
		<figure id="interactive-<?php echo $id;?>" class="interactive">
			<?php do_action('cap_report_interactiveshortcode_inside_before');?>
			<?php echo $post->post_content;?>
			<?php do_action('cap_report_interactiveshortcode_inside_end');?>
		</figure>
		<?php do_action('cap_report_interactiveshortcode_outside_end');?>

		<?php

		return ob_get_clean();

	} );

    if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
		add_action( 'admin_notices', function(){
			if ( current_user_can( 'activate_plugins' ) ) {
				echo '<div class="error message"><p>Shortcode UI plugin must be active for shortcodes to function properly.</p></div>';
			}
		});
		return;
	}

	/**
	 * Register a UI for the Shortcode.
	 * Pass the shortcode tag (string)
	 * and an array or args.
	 */
	shortcode_ui_register_for_shortcode(
		'chapter',
		array(
			// Display label. String. Required.
			'label' => 'Chapter',

			// Icon/attachment for shortcode. Optional. src or dashicons-$icon. Defaults to carrot.
			'listItemImage' => 'dashicons-editor-quote',

			'post_type'     => array( 'reports' ),

			// Available shortcode attributes and default values. Required. Array.
			// Attribute model expects 'attr', 'type' and 'label'
			// Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
			'attrs' => array(

				array(
					'label' => 'Title',
					'attr'  => 'title',
					'type'  => 'text',
					'meta' => array(
						'placeholder' => 'Chapter #',
						'data-test'    => 1,
					),
				),

				array(
					'label' => 'Chapter Background',
					'attr'  => 'background_image',
					'type'  => 'attachment',
					'libraryType' => array( 'image' ),
					'addButton'   => 'Select Image',
					'frameTitle'  => 'Select Image',
				),

			),

		)
	);

	shortcode_ui_register_for_shortcode(
		'pull_quote',
		array(
			// Display label. String. Required.
			'label' => 'Pull Quote',

			// Icon/attachment for shortcode. Optional. src or dashicons-$icon. Defaults to carrot.
			'listItemImage' => 'dashicons-editor-quote',

			'inner_content' => array(
				'label' => 'Quote',
			),

			'post_type'     => array( 'reports' ),

			// Available shortcode attributes and default values. Required. Array.
			// Attribute model expects 'attr', 'type' and 'label'
			// Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
			'attrs' => array(

				array(
					'label' => 'Alignment',
					'attr'  => 'alignment',
					'type'  => 'select',
					'options'   => array(
						'none'	=> 'None (Default)',
						'alignleft' => 'Left'
					),
				),

				array(
					'label' => 'Cite',
					'attr'  => 'source',
					'type'  => 'text',
					'meta' => array(
						'placeholder' => 'John Doe',
						'data-test'    => 1,
					),
				)

			),

		)
	);

	shortcode_ui_register_for_shortcode(
		'content',
		array(
			// Display label. String. Required.
			'label' => 'Content',

			// Icon/attachment for shortcode. Optional. src or dashicons-$icon. Defaults to carrot.
			'listItemImage' => 'dashicons-editor-quote',

			'post_type'     => array( 'reports', 'post' ),

			// Available shortcode attributes and default values. Required. Array.
			// Attribute model expects 'attr', 'type' and 'label'
			// Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
			'attrs' => array(

				array(
					'label'    => 'Select Post to Pull Content From',
					'attr'     => 'id',
					'type'     => 'post_select',
					'query'    => array( 'post_type' => 'post' ),
					'multiple' => false,
				),

				array(
					'label' => 'Style',
					'attr'  => 'style',
					'type'  => 'select',
					'options'   => array(
						'box'	=> 'Box (Default)',
						'none' => 'None'
					),
				),
			)
		)
	);

	shortcode_ui_register_for_shortcode(
		'interactive',
		array(
			// Display label. String. Required.
			'label' => 'Interactive',

			// Icon/attachment for shortcode. Optional. src or dashicons-$icon. Defaults to carrot.
			'listItemImage' => 'dashicons-editor-quote',

			'post_type'     => array( 'reports', 'post' ),

			// Available shortcode attributes and default values. Required. Array.
			// Attribute model expects 'attr', 'type' and 'label'
			// Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
			'attrs' => array(

				array(
					'label'    => 'Select Interactive to Include',
					'attr'     => 'id',
					'type'     => 'post_select',
					'query'    => array( 'post_type' => 'interactive' ),
					'multiple' => false,
				)
			)
		)
	);

	///////////////////////// END
} );

<?php
/**
    Plugin Name: Pick-n-Post Quote
    Plugin URI: https://github.com/poetsgig/pick-n-post-quote
    Description: This plugin shows a static or featured quote for current post in the sidebar. Utilizes WordPress custom field.
    Author: Amy Aulisi
	Author URI: 
    Version: 1.0.1
    License: GNU General Public License v2 or later
	License URI: http://www.gnu.org/licenses/gpl-2.0.html
	Text Domain: pick_n_post_quote
    Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
define( 'PNPQ_VERSION', '1.0.1' );

// Register and load the widget
function pick_n_post_quote_load_widget() {
    register_widget( 'pick_n_post_quote' );
}
add_action( 'widgets_init', 'pick_n_post_quote_load_widget' );
 
// Create widget 
class pick_n_post_quote extends WP_Widget {

 	function __construct() {
		parent::__construct(
 
			'pick_n_post_quote', // Base ID 

			__('Pick-n-Post Quote', 'pick_n_post_quote'), // Widget name

			array( 'description' => __( 'Shows a static or featured quote for current post. Utilizes WordPress custom field.', 'pick_n_post_quote' ), ) 
			); // Widget description
	}
	
		// Widget backend 
	public function form( $instance ) {

                $instance = wp_parse_args( (array) $instance, self::get_defaults() );

		if ( isset( $instance[ 'title' ] ) ) {
		      $title = $instance[ 'title' ];
		}
		else {
		      $title = __( 'New title', 'pick_n_post_quote' );
		}
		if ( isset( $instance[ 'display_quote' ] ) ) {
		      $instance['display_quote'] = $instance[ 'display_quote' ];
		}
		if ( isset( $instance[ 'display_author' ] ) ) {
		      $instance['display_author'] = $instance[ 'display_author' ];
		}
		if ( isset( $instance[ 'display_source' ] ) ) {
		      $instance['display_source'] = $instance[ 'display_source' ];
		}
		if ( isset( $instance[ 'font_size_quote' ] ) ) {
		      $font_size_quote = $instance[ 'font_size_quote' ];
		}
		if ( isset( $instance[ 'font_style_quote' ] ) ) {
		     $font_style_quote = $instance[ 'font_style_quote' ];
		}
		if ( isset( $instance[ 'separator' ] ) ) {
		      $separator = $instance[ 'separator' ];
		}
		else {
		      $separator = __( ' ~ ', 'pick_n_post_quote' );
		}
		if ( isset( $instance[ 'font_size_author' ] ) ) {
		     $font_size_author = $instance[ 'font_size_author' ];
		}
		if ( isset( $instance[ 'font_style_author' ] ) ) {
		     $font_style_author = $instance[ 'font_style_author' ];
		}
		if ( isset( $instance[ 'font_size_source' ] ) ) {
		     $font_size_source = $instance[ 'font_size_source' ];
		}
		if ( isset( $instance[ 'font_style_source' ] ) ) {
		     $font_style_source = $instance[ 'font_style_source' ];
		}


		
		// Widget admin form
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pick_n_post_quote' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		       <p>
               <input class="checkbox" id="<?php echo $this->get_field_id('display_quote'); ?>" type="checkbox" <?php checked( $instance[ 'display_quote' ], 1 ); ?> name="<?php echo $this->get_field_name( 'display_quote' ); ?>"   /> 
    <label for="<?php echo $this->get_field_id( 'display_quote' ); ?>"><?php esc_html_e( 'Display quote', 'pick-n-post-quote' ); ?></label>
               </p>
			   	<p>
				<input class="widefat" style="max-width: 65px;" id="<?php echo $this->get_field_id( 'font_size_quote' ); ?>" name="<?php echo $this->get_field_name( 'font_size_quote' ); ?>" type="text" value="<?php echo intval( $font_size_quote ); ?>" />
				<span class="pixels" style="display: inline-block; position: relative; background: #efefef; margin-left: -33px; padding: 3px 7px;">px</span>
    <label for="<?php echo $this->get_field_id( 'font_size_quote' ); ?>"><?php esc_html_e( 'Font size', 'pick-n-post-quote' ); ?></label> 
               </p>
			   <p>
				<select name="<?php echo $this->get_field_name( 'font_style_quote' );?>" id="<?php echo $this->get_field_id( 'font_style_quote' );?>">
					<option value="normal" <?php selected( $instance['font_style_quote'], 'normal' ); ?>><?php _e( 'Normal', 'pick-n-post-quote' );?></option>
					<option value="italic" <?php selected( $instance['font_style_quote'], 'italic' ); ?>><?php _e( 'Italic', 'pick-n-post-quote' );?></option>
					<option value="oblique" <?php selected( $instance['font_style_quote'], 'oblique' ); ?>><?php _e( 'Oblique', 'pick-n-post-quote' );?></option>
				</select>
				<?php esc_html_e( 'Font style', 'pick-n-post-quote' ); ?>
			   </p>
			   
			   <hr>
                <p>
               <input class="checkbox" id="<?php echo $this->get_field_id('display_author'); ?>" type="checkbox" <?php checked( $instance[ 'display_author' ], 1 ); ?> name="<?php echo $this->get_field_name( 'display_author' ); ?>"   /> 
    <label for="<?php echo $this->get_field_id( 'display_author' ); ?>"><?php esc_html_e( 'Display author', 'pick-n-post-quote' ); ?></label>
               </p>
			   <p>
				<input class="widefat" style="max-width: 45px;" id="pick-n-post-quote-sep <?php echo $this->get_field_id( 'separator' ); ?>" name="<?php echo $this->get_field_name( 'separator' ); ?>" type="text" value="<?php echo esc_html_e( $separator ); ?>" />
    <label for="<?php echo $this->get_field_id( 'separator' ); ?>"><?php esc_html_e( 'Separator', 'pick-n-post-quote' ); ?></label> 
               </p>
			   <p>
				<input class="widefat" style="max-width: 65px;" id="<?php echo $this->get_field_id( 'font_size_author' ); ?>" name="<?php echo $this->get_field_name( 'font_size_author' ); ?>" type="text" value="<?php echo intval( $font_size_author ); ?>" />
				<span class="pixels" style="display: inline-block; position: relative; background: #efefef; margin-left: -33px; padding: 3px 7px;">px</span>
    <label for="<?php echo $this->get_field_id( 'font_size_author' ); ?>"><?php esc_html_e( 'Font size', 'pick-n-post-quote' ); ?></label> 
               </p>
			   <p>
				<select name="<?php echo $this->get_field_name( 'font_style_author' );?>" id="<?php echo $this->get_field_id( 'font_style_author' );?>">
					<option value="normal" <?php selected( $instance['font_style_author'], 'normal' ); ?>><?php _e( 'Normal', 'pick-n-post-quote' );?></option>
					<option value="italic" <?php selected( $instance['font_style_author'], 'italic' ); ?>><?php _e( 'Italic', 'pick-n-post-quote' );?></option>
					<option value="oblique" <?php selected( $instance['font_style_author'], 'oblique' ); ?>><?php _e( 'Oblique', 'pick-n-post-quote' );?></option>
				</select>
				<?php esc_html_e( 'Font style', 'pick-n-post-quote' ); ?>
			   </p>
			   
			   <hr>
			   <p>
               <input class="checkbox" id="<?php echo $this->get_field_id('display_source'); ?>" type="checkbox" <?php checked( $instance[ 'display_source' ], 1 ); ?> name="<?php echo $this->get_field_name( 'display_source' ); ?>"   /> 
    <label for="<?php echo $this->get_field_id( 'display_source' ); ?>"><?php esc_html_e( 'Display source', 'pick-n-post-quote' ); ?></label>
               </p>
			   <p>
				<input class="widefat" style="max-width: 65px;" id="<?php echo $this->get_field_id( 'font_size_source' ); ?>" name="<?php echo $this->get_field_name( 'font_size_source' ); ?>" type="text" value="<?php echo intval( $font_size_source ); ?>" />
				<span class="pixels" style="display: inline-block; position: relative; background: #efefef; margin-left: -33px; padding: 3px 7px;">px</span>
    <label for="<?php echo $this->get_field_id( 'font_size_source' ); ?>"><?php esc_html_e( 'Font size', 'pick-n-post-quote' ); ?></label> 
               </p>
			   <p>
				<select name="<?php echo $this->get_field_name( 'font_style_source' );?>" id="<?php echo $this->get_field_id( 'font_style_source' );?>">
					<option value="normal" <?php selected( $instance['font_style_source'], 'normal' ); ?>><?php _e( 'Normal', 'pick-n-post-quote' );?></option>
					<option value="italic" <?php selected( $instance['font_style_source'], 'italic' ); ?>><?php _e( 'Italic', 'pick-n-post-quote' );?></option>
					<option value="oblique" <?php selected( $instance['font_style_source'], 'oblique' ); ?>><?php _e( 'Oblique', 'pick-n-post-quote' );?></option>
				</select>
				<?php esc_html_e( 'Font style', 'pick-n-post-quote' ); ?>
			   </p>
        <?php
	}
        // Sanitize widget form values as they are saved
    	// Update widget to replace old instances with new
	public function update( $new_instance, $instance ) {
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
                //Add isset to check if key is set
				$instance['display_quote'] 		= isset( $new_instance['display_quote'] ) ? 1 : 0;
                $instance['display_author']	 	= isset( $new_instance['display_author'] ) ? 1 : 0;
                $instance['display_source'] 	= isset( $new_instance['display_source'] ) ? 1 : 0;
				$instance['font_size_quote']	= intval( $new_instance['font_size_quote'] );
				$instance['font_style_quote'] 	= strip_tags( $new_instance['font_style_quote'] );
				$instance['font_size_author'] 	= intval( $new_instance['font_size_author'] );
				$instance['font_style_author'] 	= strip_tags( $new_instance['font_style_author'] );
				$instance['font_size_source'] 	= intval( $new_instance['font_size_source'] );
				$instance['font_style_source'] 	= strip_tags( $new_instance['font_style_source'] );
				$instance['separator'] 			= ( ! empty( $new_instance['separator'] ) ) ? strip_tags( $new_instance['separator'] ) : '';

                $updated_instance = wp_parse_args( (array) $instance, self::get_defaults() );
                return $updated_instance;
	}
	
	// Render an array of default values
	private static function get_defaults() {
		   $defaults = array(
			  'display_quote' => 1,
			  'display_author' => 1,
			  'display_source' => 0,
			  'font_size_quote' => 18,
			  'font_style_quote' => 'italic',
			  'font_size_author' => 18,
			  'font_style_author' => 'normal',
			  'font_size_source' => 16,
			  'font_style_source' => 'italic',
		   );
		return $defaults; 
	}
	// Widget front-end
	public function widget( $args, $instance ) {
                extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
		$display_quote = isset( $instance[ 'display_quote' ] ) ? 1 : 0;
		$display_author = isset( $instance[ 'display_author' ] ) ? 1 : 0;
        $display_source = isset( $instance[ 'display_source' ] ) ? 1 : 0;
		$font_size_quote = ( isset( $instance['font_size_quote'] ) && '' !== $instance['font_size_quote'] ) ? $instance['font_size_quote'] : $defaults['font_size_quote'];
		$font_style_quote = ( isset( $instance['font_style_quote'] ) && '' !== $instance['font_style_quote'] ) ? $instance['font_style_quote'] : $defaults['font_style_quote'];
		$font_size_author = ( isset( $instance['font_size_author'] ) && '' !== $instance['font_size_author'] ) ? $instance['font_size_author'] : $defaults['font_size_author'];
		$font_style_author = ( isset( $instance['font_style_author'] ) && '' !== $instance['font_style_author'] ) ? $instance['font_style_author'] : $defaults['font_style_author'];
		$font_size_source = ( isset( $instance['font_size_source'] ) && '' !== $instance['font_size_source'] ) ? $instance['font_size_source'] : $defaults['font_size_source'];
		$font_style_source = ( isset( $instance['font_style_source'] ) && '' !== $instance['font_style_source'] ) ? $instance['font_style_source'] : $defaults['font_style_source'];
		$separator = apply_filters( 'widget_text', $instance['separator'] );
      
	  	$css = "#pick-n-post-quote {
					font-size: {$font_size_quote}px !important;
					font-style: {$font_style_quote} !important;
				}
				#pick-n-post-quote-author {
					font-size: {$font_size_author}px !important;
					font-style: {$font_style_author} !important;
				}
				#pick-n-post-quote-source {
					font-size: {$font_size_source}px !important;
					font-style: {$font_style_source} !important;
				}
			";

		wp_enqueue_style( 'pnpq-style', plugin_dir_url( __FILE__ ) . 'css/style.css', array(), PNPQ_VERSION, 'all' );
		wp_add_inline_style( 'pnpq-style', $css, 99 );
	  
			 // Before and after widget arguments are defined by themes
			echo $args['before_widget'];
			
			if ( ! empty( $title ) )  {
				echo $args['before_title'] . $title . $args['after_title'];
			}
		   // Run the code and display the output
				?>

			
				<?php global $post;

					$pick_n_post_quote = get_post_meta($post->ID, 'pick_n_post_quote', true);
					$pick_n_post_quote_author = get_post_meta($post->ID, 'pick_n_post_quote_author', true);
					$pick_n_post_quote_source = get_post_meta($post->ID, 'pick_n_post_quote_source', true);

					if ( !empty($pick_n_post_quote) ) { ?>
						<div id='pick-n-post'>		
							<?php if( 1 == $instance[ 'display_quote' ] ) : ?>
								<div id="pick-n-post-quote">
									<?php echo esc_html( $pick_n_post_quote ); ?>
								</div>
							<?php endif; ?>
							<?php if( 1 == $instance[ 'display_author' ] ) : ?>
								<div id="pick-n-post-quote-author">
									<span id="pick-n-post-quote-sep"><?php echo esc_attr( $separator ); ?></span> <?php echo esc_html( $pick_n_post_quote_author ); ?>
								</div>
							<?php endif; ?>

							<?php if( 1 == $instance[ 'display_source' ] ) : ?>
								<div id="pick-n-post-quote-source">
									<?php echo esc_html( $pick_n_post_quote_source ); ?>
								</div>
							<?php endif; ?>
						</div>
					<?php } else {
						// Do nothing if there is no pick-n-post-quote
					} ?>
							
				<?php echo $args['after_widget']; ?>
															
			  
			<?php if ( $title ) { 
				echo $before_title . $title . $after_title;
			}				             
	}

} // End of class pick_n_post_quote


// Load the stylesheet
function pick_n_post_quote_load_plugin_css() {
	$plugin_url = plugin_dir_url(__FILE__ );

	wp_enqueue_style( 'style', $plugin_url . 'css/style.css' );
	
}
add_action( 'wp_enqueue_scripts', 'pick_n_post_quote_load_plugin_css' );

	

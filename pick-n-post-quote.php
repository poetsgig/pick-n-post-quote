<?php
/**
    Plugin Name: Pick-n-Post Quote
    Plugin URI: https://github.com/poetsgig/pick-n-post-quote
    Description: This plugin shows a static or featured quote for current post in the sidebar. Utilizes WordPress custom field.
    Author: Amy Aulisi
    Author URI: 
    Version: 1.0.4
    License: GNU General Public License v2 or later
    License URI: http://www.gnu.org/licenses/gpl-2.0.html
    Text Domain: pick_n_post_quote
    Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
define( 'PNPQ_VERSION', '1.0.4' );


/**
 * Register and load the widget
 * @since 1.0.1
 */
	add_action( 'widgets_init', 'pick_n_post_quote_load_widget' );
function pick_n_post_quote_load_widget() {
    register_widget( 'pick_n_post_quote' );
}


/**
 * Create widget 
 * @since 1.0.1
 */
class pick_n_post_quote extends WP_Widget {

 	function __construct() {
		parent::__construct(
 
			'pick_n_post_quote', // Base ID 

			__('Pick-n-Post Quote', 'pick_n_post_quote'), // Widget name

			array( 'description' => __( 'Shows a static or featured quote for current post. Utilizes WordPress custom field.', 'pick_n_post_quote' ), ) 
			); // Widget description
			
				// Widget scripts
			$this->scripts['pnpq_scripts'] = false;

			add_action( 'admin_enqueue_scripts', array( $this, 'pnpq_enqueue_admin_scripts' ) );
			add_action( 'admin_footer-widgets.php', array( $this, 'print_scripts' ), 9999 ); // Add scripts in footer
	}
	
	/**
	 * Widget backend 
	 * @since 1.0.1
	 */
	public function form( $instance ) {

		$defaults = pnpq_get_defaults();
        $instance = wp_parse_args( (array) $instance, $defaults );

		if ( isset( $instance[ 'title' ] ) ) {
		      $title = $instance[ 'title' ];
		}
		else {
		      $title = __( 'Quote', 'pick_n_post_quote' );
		}
		if ( isset( $instance[ 'separator' ] ) ) {
		      $separator = $instance[ 'separator' ];
		}
		else {
		      $separator = __( ' ~ ', 'pick_n_post_quote' );
		}

		$active_on_page 	= isset( $instance[ 'active_on_page' ] ) ? 1 : 0;
		$display_quote 		= isset( $instance[ 'display_quote' ] ) ? 1 : 0;
		$display_author 	= isset( $instance[ 'display_author' ] ) ? 1 : 0;
        $display_source 	= isset( $instance[ 'display_source' ] ) ? 1 : 0;
		$font_size_quote 	= ( isset( $instance['font_size_quote'] ) && '' !== $instance['font_size_quote'] ) ? $instance['font_size_quote'] : $defaults['font_size_quote'];
		$font_style_quote 	= isset( $instance['font_style_quote'] ) ? $instance['font_style_quote'] : $defaults['font_style_quote'];
		$quote_alignment 	= isset( $instance['quote_alignment'] ) ? $instance['quote_alignment'] : $defaults['quote_alignment'];
		$font_size_author 	= ( isset( $instance['font_size_author'] ) && '' !== $instance['font_size_author'] ) ? $instance['font_size_author'] : $defaults['font_size_author'];
		$font_style_author 	= isset( $instance['font_style_author'] ) ? $instance['font_style_author'] : $defaults['font_style_author'];
		$author_alignment 	= isset( $instance['author_alignment'] ) ? $instance['author_alignment'] : $defaults['author_alignment'];
		$font_size_source 	= ( isset( $instance['font_size_source'] ) && '' !== $instance['font_size_source'] ) ? $instance['font_size_source'] : $defaults['font_size_source'];
		$font_style_source 	= isset( $instance['font_style_source'] ) ? $instance['font_style_source'] : $defaults['font_style_source'];
		$source_alignment 	= isset( $instance['source_alignment'] ) ? $instance['source_alignment'] : $defaults['source_alignment'];
		$text_color_quote = ( isset( $instance[ 'text_color_quote' ] ) && '' !== $instance[ 'text_color_quote' ] ) ? $instance[ 'text_color_quote' ] : $defaults['text_color_quote'];
		$text_color_author = ( isset( $instance[ 'text_color_author' ] ) && '' !== $instance[ 'text_color_author' ] ) ? $instance[ 'text_color_author' ] : $defaults['text_color_author'];
		$text_color_source = ( isset( $instance[ 'text_color_source' ] ) && '' !== $instance[ 'text_color_source' ] ) ? $instance[ 'text_color_source' ] : $defaults['text_color_source'];
		
		/**
		 * Widget form
		 * @since 1.0.1
		 */
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'pick_n_post_quote' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		<input class="checkbox" id="<?php echo $this->get_field_id('active_on_page'); ?>" type="checkbox" <?php checked( $instance[ 'active_on_page' ], 1 ); ?> name="<?php echo $this->get_field_name( 'active_on_page' ); ?>"   /> 
		<label for="<?php echo $this->get_field_id( 'active_on_page' ); ?>"><?php esc_html_e( 'Activate also on static pages?', 'pick-n-post-quote' ); ?></label>
		</p>
	   
		<hr>
		<p>
		<input style="cursor: none;"class="checkbox" id="<?php echo $this->get_field_id('display_quote'); ?>" type="checkbox" <?php checked( $instance[ 'display_quote' ], 1 ); ?> name="<?php echo $this->get_field_name( 'display_quote' );?>" disabled="disabled"  /> 
		<label style="color: #aaa; cursor: none;" for="<?php echo $this->get_field_id( 'display_quote' ); ?>"><?php esc_html_e( 'Display quote', 'pick-n-post-quote' ); ?></label>
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
		<p>
		<select style="width: 80px;" name="<?php echo $this->get_field_name( 'quote_alignment' );?>" id="<?php echo $this->get_field_id( 'quote_alignment' );?>">
			<option value="left" <?php selected( $instance['quote_alignment'], 'left' ); ?>><?php _e( 'Left', 'pick-n-post-quote' );?></option>
			<option value="center" <?php selected( $instance['quote_alignment'], 'center' ); ?>><?php _e( 'Center', 'pick-n-post-quote' );?></option>
			<option value="right" <?php selected( $instance['quote_alignment'], 'right' ); ?>><?php _e( 'Right', 'pick-n-post-quote' );?></option>
		</select>
		<?php esc_html_e( 'Alignment', 'pick-n-post-quote' ); ?>
		</p>
		<p>
		<input class="widefat color-picker" style="max-width: 80px;" id="<?php echo $this->get_field_id( 'text_color_quote' ); ?>" name="<?php echo $this->get_field_name( 'text_color_quote' ); ?>" type="text" value="<?php echo $text_color_quote; ?>">
		<label style="font-size: 90%;"><?php esc_html_e( 'Text Color', 'pick-n-post-quote' ); ?></label>
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
		<p>
		<select style="width: 80px;" name="<?php echo $this->get_field_name( 'author_alignment' );?>" id="<?php echo $this->get_field_id( 'author_alignment' );?>">
			<option value="left" <?php selected( $instance['author_alignment'], 'left' ); ?>><?php _e( 'Left', 'pick-n-post-quote' );?></option>
			<option value="center" <?php selected( $instance['author_alignment'], 'center' ); ?>><?php _e( 'Center', 'pick-n-post-quote' );?></option>
			<option value="right" <?php selected( $instance['author_alignment'], 'right' ); ?>><?php _e( 'Right', 'pick-n-post-quote' );?></option>
		</select>
		<?php esc_html_e( 'Alignment', 'pick-n-post-quote' ); ?>
		</p>
		<p>
		<input class="widefat color-picker" style="max-width: 80px;" id="<?php echo $this->get_field_id( 'text_color_author' ); ?>" name="<?php echo $this->get_field_name( 'text_color_author' ); ?>" type="text" value="<?php echo $text_color_author; ?>">
		<label style="font-size: 90%;"><?php esc_html_e( 'Text Color', 'pick-n-post-quote' ); ?></label>
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
		<p>
		<select style="width: 80px;" name="<?php echo $this->get_field_name( 'source_alignment' );?>" id="<?php echo $this->get_field_id( 'source_alignment' );?>">
			<option value="left" <?php selected( $instance['source_alignment'], 'left' ); ?>><?php _e( 'Left', 'pick-n-post-quote' );?></option>
			<option value="center" <?php selected( $instance['source_alignment'], 'center' ); ?>><?php _e( 'Center', 'pick-n-post-quote' );?></option>
			<option value="right" <?php selected( $instance['source_alignment'], 'right' ); ?>><?php _e( 'Right', 'pick-n-post-quote' );?></option>
		</select>
		<?php esc_html_e( 'Alignment', 'pick-n-post-quote' ); ?>
		</p>
		<p>
		<input class="widefat color-picker" style="max-width: 80px;" id="<?php echo $this->get_field_id( 'text_color_source' ); ?>" name="<?php echo $this->get_field_name( 'text_color_source' ); ?>" type="text" value="<?php echo $text_color_source; ?>">
		<label style="font-size: 90%;"><?php esc_html_e( 'Text Color', 'pick-n-post-quote' ); ?></label>
		</p>
			   		  
        <?php
	}
	
	/**
	 * Sanitize widget form values as they are saved
	 * Update widget to replace old instances with new
	 * @since 1.0.1
	 */
	public function update( $new_instance, $instance ) {
				
		$defaults = pnpq_get_defaults();
		
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		//Add isset to check if key is set
		$instance['active_on_page'] 	= isset( $new_instance['active_on_page'] ) ? 1 : 0;
		$instance['display_quote'] 		= isset( $new_instance['display_quote'] ) ? 1 : 0;
		$instance['display_author']	 	= isset( $new_instance['display_author'] ) ? 1 : 0;
		$instance['display_source'] 	= isset( $new_instance['display_source'] ) ? 1 : 0;
		$instance['font_size_quote']	= intval( $new_instance['font_size_quote'] );
		$instance['font_style_quote'] 	= strip_tags( $new_instance['font_style_quote'] );
		$instance['quote_alignment'] 	= strip_tags( $new_instance['quote_alignment'] );
		$instance['font_size_author'] 	= intval( $new_instance['font_size_author'] );
		$instance['font_style_author'] 	= strip_tags( $new_instance['font_style_author'] );
		$instance['author_alignment'] 	= strip_tags( $new_instance['author_alignment'] );
		$instance['font_size_source'] 	= intval( $new_instance['font_size_source'] );
		$instance['font_style_source'] 	= strip_tags( $new_instance['font_style_source'] );
		$instance['source_alignment'] 	= strip_tags( $new_instance['source_alignment'] );
		$instance['separator'] 			= ( ! empty( $new_instance['separator'] ) ) ? strip_tags( $new_instance['separator'] ) : '';
		$instance['text_color_quote'] 	= pnpq_sanitize_hex_color( $new_instance['text_color_quote'] );
		$instance['text_color_author'] 	= pnpq_sanitize_hex_color( $new_instance['text_color_author'] );
		$instance['text_color_source'] 	= pnpq_sanitize_hex_color( $new_instance['text_color_source'] );
		
		$updated_instance = wp_parse_args( (array) $instance, $defaults );
		return $updated_instance;
	}
	

	/**
	 * Widget frontend
	 * @since 1.0.1
	 */
	public function widget( $args, $instance ) {
                extract( $args );

		$this->scripts['pnpq_scripts'] = true;
					
		$defaults = pnpq_get_defaults();
				
		$title = apply_filters( 'widget_title', $instance['title'] );
		$active_on_page 	= isset( $instance[ 'active_on_page' ] ) ? 1 : 0;
		$display_quote 		= isset( $instance[ 'display_quote' ] ) ? 1 : 0;
		$display_author 	= isset( $instance[ 'display_author' ] ) ? 1 : 0;
        $display_source 	= isset( $instance[ 'display_source' ] ) ? 1 : 0;
		$font_size_quote 	= ( isset( $instance['font_size_quote'] ) && '' !== $instance['font_size_quote'] ) ? $instance['font_size_quote'] : $defaults['font_size_quote'];
		$font_style_quote 	= isset( $instance['font_style_quote'] ) ? $instance['font_style_quote'] : $defaults['font_style_quote'];
		$quote_alignment 	= isset( $instance['quote_alignment'] ) ? $instance['quote_alignment'] : $defaults['quote_alignment'];
		$font_size_author 	= ( isset( $instance['font_size_author'] ) && '' !== $instance['font_size_author'] ) ? $instance['font_size_author'] : $defaults['font_size_author'];
		$font_style_author 	= isset( $instance['font_style_author'] ) ? $instance['font_style_author'] : $defaults['font_style_author'];
		$author_alignment 	= isset( $instance['author_alignment'] ) ? $instance['author_alignment'] : $defaults['author_alignment'];
		$font_size_source 	= ( isset( $instance['font_size_source'] ) && '' !== $instance['font_size_source'] ) ? $instance['font_size_source'] : $defaults['font_size_source'];
		$font_style_source 	= isset( $instance['font_style_source'] ) ? $instance['font_style_source'] : $defaults['font_style_source'];
		$source_alignment 	= isset( $instance['source_alignment'] ) ? $instance['source_alignment'] : $defaults['source_alignment'];
		$text_color_quote = ( isset( $instance[ 'text_color_quote' ] ) && '' !== $instance[ 'text_color_quote' ] ) ? $instance[ 'text_color_quote' ] : $defaults['text_color_quote'];
		$text_color_author = ( isset( $instance[ 'text_color_author' ] ) && '' !== $instance[ 'text_color_author' ] ) ? $instance[ 'text_color_author' ] : $defaults['text_color_author'];
		$text_color_source	= ( isset( $instance['text_color_source'] ) && '' !== $instance['text_color_source'] ) ? $instance['text_color_source'] : $defaults['text_color_source'];
		$separator = apply_filters( 'widget_text', $instance['separator'] );
      
	    // Check if widget needs to be active also on static pages. Otherwise by default show only on single posts.
		if( 0 == isset( $instance[ 'active_on_page' ] ) ) {          
			$page_type = is_single();	
		} else if( 1 == isset( $instance[ 'active_on_page' ] ) ) {
			$page_type = is_singular();
		} 
		
	    if ( $page_type ) {
			
			// Run the code and display the output
			global $post;

			$pick_n_post_quote 			= get_post_meta($post->ID, 'pick_n_post_quote', true);
			$pick_n_post_quote_author 	= get_post_meta($post->ID, 'pick_n_post_quote_author', true);
			$pick_n_post_quote_source 	= get_post_meta($post->ID, 'pick_n_post_quote_source', true);


				// Show output only if quote exists
				if ( !empty($pick_n_post_quote) ) { 
					
					// Before and after widget arguments are defined by themes
					echo $args['before_widget'];
					
					// Widget title
					if ( ! empty( $title ) )  {
						echo $args['before_title'] . $title . $args['after_title'];
					} ?>
	
						<div id="pick-n-post-container">
						<?php if( 1 == $instance[ 'display_quote' ] ) : 							
						printf( '<div id="pick-n-post-quote" style="font-size: %1$spx; font-style: %2$s; text-align: %3$s; color: %4$s;">',
							$font_size_quote,
							$font_style_quote,
							$quote_alignment,
							$text_color_quote
						);?>
								<?php echo esc_html( $pick_n_post_quote ); ?>
							</div>
						<?php endif; ?>
						<?php if( 1 == $instance[ 'display_author' ] ) : 
						printf( '<div id="pick-n-post-quote-author" style="font-size: %1$spx; font-style: %2$s; text-align: %3$s; color: %4$s;">',
							$font_size_author,
							$font_style_author,
							$author_alignment,
							$text_color_author
						);?>
								<span id="pick-n-post-quote-sep"><?php echo esc_attr( $separator ); ?></span> <?php echo esc_html( $pick_n_post_quote_author ); ?>
							</div>
						<?php endif; ?>

						<?php if( 1 == $instance[ 'display_source' ] ) : 
						printf( '<div id="pick-n-post-quote-source" style="font-size: %1$spx; font-style: %2$s; text-align: %3$s; color: %4$s;">',
							$font_size_source,
							$font_style_source,
							$source_alignment,
							$text_color_source
						);?>
								<?php echo esc_html( $pick_n_post_quote_source ); ?>
							</div>
						<?php endif; ?>
					</div>
					
			<?php } else {
				// Do nothing if there is no pick-n-post-quote
			} ?>
						
		<?php echo $args['after_widget']; ?>
																             
	<?php }
	}
	
	/**
	 * Enqueue the admin scripts
	 * @since 1.0.4
	 */
	function pnpq_enqueue_admin_scripts() {
		$screen = get_current_screen();
		if ( 'widgets' !== $screen->base ) {
			return;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
	}

	public function print_scripts() {
		?>
		<script>
			( function( $ ){
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						change: _.throttle( function() { // For WP Customizer
							$(this).trigger( 'change' );
						}, 3000 )
					});
				}

				function onFormUpdate( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.color-picker)' ).each( function () {
						initColorPicker( $( this ) );
					} );
				} );
			}( jQuery ) );
		</script>
		<?php
	}


} // End of class pick_n_post_quote


/**
 * Render an array of default values
 * @since 1.0.1
 */
function pnpq_get_defaults() {
	   $defaults = array(
		  'active_on_page' 	 	=> 0,
		  'display_quote' 		=> 1,
		  'display_author' 		=> 1,
		  'display_source' 		=> 0,
		  'font_size_quote' 	=> 18,
		  'font_style_quote' 	=> 'normal',
		  'quote_alignment' 	=> 'left',
		  'font_size_author' 	=> 18,
		  'font_style_author' 	=> 'normal',
		  'author_alignment' 	=> 'right',
		  'font_size_source' 	=> 16,
		  'font_style_source' 	=> 'italic',
		  'source_alignment' 	=> 'right',
		  'text_color_quote' 	=> '#222222',
		  'text_color_author' 	=> '#222222',
		  'text_color_source' 	=> '#677870'
		  
	   );
	   
	return apply_filters( 'pnpq_get_defaults', $defaults );
}
	
/**
 * Sanitize the hex values
 * @since 1.0.4
 */
function pnpq_sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}


/**
 * Load the stylesheet
 * @since 1.0.1
 */ 
function pnpq_load_plugin_css() {
	$plugin_url = plugin_dir_url(__FILE__ );

	wp_enqueue_style( 'pnpq-style', $plugin_url . 'css/style.css', array(), PNPQ_VERSION, 'all' );
}
add_action( 'wp_enqueue_scripts', 'pnpq_load_plugin_css' );

	

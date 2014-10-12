<?php
/**
 * Plugin Name: DX Testimonials
 * Description: Some testimonials plugin
 * 
 */

if ( ! class_exists( 'DX_Testimonials' ) ) {
    class DX_Testimonials {
        
        public function __construct() {
            add_action( 'init', 
                array( $this, 'register_testimonial' ) );
            add_action( 'add_meta_boxes', 
                array( $this, 'meta_boxes' ) );
            add_action( 'save_post', array(
                $this, 'testimonail_save'
            ) );   
            
            add_action( 'init', array( $this, 'shortcode' ) );
        }
        
        public function shortcode() {
            add_shortcode( 'testimonials', array( $this, 'shortcode_cb' ) );
        }
        
        public function shortcode_cb( $args ) {
            $out = '';
            
            $query = new WP_Query( array(
                'post_type' => 'testimonial',
                'posts_per_page' => -1 
               )
            );
            
            if ( $query->have_posts() ) {
                while( $query->have_posts() ) {
                    $query->the_post();
                    
                    $out .= '<p><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></p>'; 
                }
            }
            
            return $out;
        }
        
        public function testimonail_save( $post_id ) {
            if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
                return $post_id;
            }
            
            if ( isset( $_POST['auth_name'] ) ) {
                update_post_meta( $post_id, 'auth_name',
                 $_POST['auth_name'] );
            }
            
            return $post_id;
        }
        
        public function meta_boxes() {
            add_meta_box( 'test_meta' , 
            'Additional', array( $this, 'meta_box_cb' ), 'testimonial' );
        }
        
        public function meta_box_cb( $post ) {
            $auth_name = '';
            if ( ! empty( $post ) ) {
                $auth_name = get_post_meta( $post->ID, 
                'auth_name', true );
                
            }
            ?>
            <p>Author Name:</p>
            <input type="text" name="auth_name" value="<?php echo $auth_name; ?>" />
            <?php
        }
        
        public function register_testimonial() {
            register_post_type( 'testimonial',
                array(
                    'labels' => array(
                        'name' => 'Testimonials',
                        'singular_name' => 'Testimonial'
                    ),
                    'public' => true,
                    'has_archive' => true
                ) 
            );
        }
    }
    
    new DX_Testimonials();
}

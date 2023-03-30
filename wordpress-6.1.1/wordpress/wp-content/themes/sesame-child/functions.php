<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'sesame_style','sesame_style','sesame_all_styles','sesame_customizer' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );


//Add Social Share icons on WordPress Posts.
function social_share_links() {
	global $post;
	$content = '';
	if(is_singular()) {

		// Get current page's URL
		$sl_url = urlencode(get_permalink());

		// Get current page title - replace space by %20
		$sl_title = str_replace(' ', '%20', get_the_title());

		// Construct social sharing URLs
		$twitterURL = 'https://twitter.com/intent/tweet?text='.$sl_title.'&url='.$sl_url.'&via=[twitter username]';
		$facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$sl_url;
		$redditURL = 'https://www.reddit.com/submit?url='.$sl_url.'&title='.$sl_title;
		$linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$sl_url.'&title='.$sl_title;

		// Add sharing links at the end of page/page content
		$content = '<div class="social-box"><div class="social-btn">Social Share: ';
		$content .= '<a class="col-2 sbtn s-twitter" href="'. $twitterURL .'" target="_blank" rel="nofollow"><li>Twitter</li></a>';
		$content .= '<a class="col-2 sbtn s-facebook" href="'.$facebookURL.'" target="_blank" rel="nofollow"><li>Facebook</li></a>';
		$content .= '<a class="col-2 sbtn s-linkedin" href="'.$linkedInURL.'" target="_blank" rel="nofollow"><li>LinkedIn</li></a>';
		$content .= '<a class="col-2 sbtn s-reddit" href="'.$redditURL.'" target="_blank" rel="nofollow"><li>Reddit</li></a>';
		$content .= '</div></div>';

		return $content;
	} else {
		// if not a post/page then don't include sharing links
		return $content;
	}
}
add_shortcode('social_share_links','social_share_links');


//Init Hook for the custom post type
add_action('init', 'custom_post_type_movies');
function custom_post_type_movies() {
	$supports = array(
		'title', // post title
		'editor', // post content
		'author', // post author
		'thumbnail', // featured images
		'excerpt', // post excerpt
		'custom-fields', // custom fields
		'comments', // post comments
		'revisions', // post revisions
		'post-formats', // post formats
	);

	$labels = array(
            'name' => _x('Movie', 'plural'),
		'singular_name' => _x('Movie', 'singular'),
		'menu_name' => _x('Movie', 'admin menu'),
		'name_admin_bar' => _x('Movie', 'admin bar'),
		'add_new' => _x('Add New', 'add new'),
		'add_new_item' => __('Add New Movie'),
		'new_item' => __('New Movie'),
		'edit_item' => __('Edit Movie'),
		'view_item' => __('View Movie'),
		'all_items' => __('All Movie'),
		'search_items' => __('Search Movie'),
		'not_found' => __('No Movie found.'),
	);

	$args = array(
		'supports' => $supports,
		'labels' => $labels,
		'description' => 'Holds our movie and specific data',
		'public' => true,
		'taxonomies' => array( 'category'),
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_nav_menus' => true,
		'show_in_admin_bar' => true,
		'can_export' => true,
		'capability_type' => 'post',
		'show_in_rest' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'movie'),
		'has_archive' => true,
		'hierarchical' => true,
		'menu_position' => 6,
		'menu_icon' => 'dashicons-megaphone',
	);

	register_post_type('movie', $args); // Register Post type
}

add_filter('pre_get_posts', 'query_post_type');
function query_post_type($query) {
	if( is_category() ) {
		$post_type = get_query_var('post_type');
		if($post_type)
			$post_type = $post_type;
		else
			$post_type = array('nav_menu_item', 'post', 'movie'); // don't forget nav_menu_item to allow menus to work!
		$query->set('post_type',$post_type);
		return $query;
	}
}

//creating testimonial post type
function create_testimonial_post_type() {
	$labels = array(
		'name'               => __( 'Testimonials' ),
		'singular_name'      => __( 'Testimonial' ),
		'add_new'            => __( 'Add New' ),
		'add_new_item'       => __( 'Add New Testimonial' ),
		'edit_item'          => __( 'Edit Testimonial' ),
		'new_item'           => __( 'New Testimonial' ),
		'all_items'          => __( 'All Testimonials' ),
		'view_item'          => __( 'View Testimonial' ),
		'search_items'       => __( 'Search Testimonials' ),
		'not_found'          => __( 'No testimonials found' ),
		'not_found_in_trash' => __( 'No testimonials found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Testimonials'
	);
	$args = array(
		'labels'             => $labels,
		'description'        => 'Testimonials',
		'public'             => true,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor' ),
		'has_archive'        => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'show_in_rest'       => true,
		'menu_icon'          => 'dashicons-format-quote'
	);
	register_post_type( 'testimonial', $args );
}
add_action( 'init', 'create_testimonial_post_type' );
function add_testimonial_author_meta_box() {
	add_meta_box('testimonial_author', 'Author', 'render_testimonial_author_meta_box', 'testimonial', 'side');
}
add_action('add_meta_boxes', 'add_testimonial_author_meta_box');

function render_testimonial_author_meta_box($post) {
	wp_nonce_field('save_testimonial_author_meta', 'testimonial_author_meta_nonce');
	$author = get_post_meta($post->ID, 'testimonial_author', true);
	echo '<input type="text" name="testimonial_author" value="' . esc_attr($author) . '" class="widefat">';
}

function save_testimonial_author_meta($post_id) {
	if (!isset($_POST['testimonial_author_meta_nonce']) || !wp_verify_nonce($_POST['testimonial_author_meta_nonce'], 'save_testimonial_author_meta')) {
		return;
	}
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}
	if (!current_user_can('edit_post', $post_id)) {
		return;
	}
	if (isset($_POST['testimonial_author'])) {
		update_post_meta($post_id, 'testimonial_author', sanitize_text_field($_POST['testimonial_author']));
	} else {
		delete_post_meta($post_id, 'testimonial_author');
	}
}
add_action('save_post_testimonial', 'save_testimonial_author_meta');

//slider code
add_shortcode( 'testimonial_slider', 'testimonial_slider_shortcode' );
function testimonial_slider_shortcode($atts) {
	ob_start();
	$query = new WP_Query(array(
		'post_type' => 'testimonial',
		'posts_per_page' => 1
	));

	if ($query->have_posts()) {
		wp_register_script('jquery', get_stylesheet_directory_uri() . '/assets/js/jquery-3.3.1.js' ); // enqueue jQuery
		wp_register_script('slick-js', get_stylesheet_directory_uri() .'/assets/js/slick.min.js', array('jquery'), true); // enqueue slick JS
		wp_register_script('slick-css', get_stylesheet_directory_uri(). '/assets/css/slick.css', array(), '1.6.0', 'all'); // enqueue slick CSS

		wp_enqueue_script('jquery');
        wp_enqueue_script('slick-js');
        wp_enqueue_script('slick-css');

		?>
        <div class="testimonial-slider-container">
            <div class="testimonial-slider">
				<?php
				while ($query->have_posts()) {
					$query->the_post();
					?>
                    <div class="testimonial-slide">
                        <div class="testimonial-content">
							<?php the_content(); ?>
                        </div>
                        <div class="testimonial-author">
							<?php the_title(); ?>
                        </div>
                    </div>
					<?php
				}
				wp_reset_postdata();
				?>
            </div>
            <button class="testimonial-slider-button">Next</button>
        </div>
        <script>
            jQuery('.testimonial-slider').slick({
                slidesToShow: 1,
                slidesToScroll: 1
            });
            jQuery('.testimonial-slider-button').click(function() {
                jQuery('.testimonial-slider').slick('slickNext');
            });
        </script>
		<?php
	}

	$output = ob_get_clean();
	return $output;
}

// END ENQUEUE PARENT ACTION

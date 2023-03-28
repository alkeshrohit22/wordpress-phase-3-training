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
		$content .= '<a class="col-2 sbtn s-twitter" href="'. $twitterURL .'" target="_blank" rel="nofollow"></a>';
		$content .= '<a class="col-2 sbtn s-facebook" href="'.$facebookURL.'" target="_blank" rel="nofollow"><span>Facebook</span></a>';
		$content .= '<a class="col-2 sbtn s-linkedin" href="'.$linkedInURL.'" target="_blank" rel="nofollow"><span>LinkedIn</span></a>';
		$content .= '<a class="col-2 sbtn s-reddit" href="'.$redditURL.'" target="_blank" rel="nofollow"><span>Reddit</span></a>';
		$content .= '</div></div>';

		return $content;
	} else {
		// if not a post/page then don't include sharing links
		return $content;
	}
}

add_shortcode('social_share_links','social_share_links');
// END ENQUEUE PARENT ACTION

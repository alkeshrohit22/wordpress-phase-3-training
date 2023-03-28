<?php
/**
 * Plugin Name: Dynamic Copyright Year
 * Description: This plugin Adds a dynamic copyright year to the footer of your website.
 * Version: 1.0.0
 * Author: Alkesh Rohit
 */

// Add the dynamic year to the footer
function dynamic_copyright_year() {
	$current_year = date('Y');
	echo '<div class="custom-footer-section">Copyright &copy; ' . $current_year . '  All rights reserved.</div>';
}
add_action( 'wp_footer', 'dynamic_copyright_year');
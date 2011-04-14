<?php
/**
 * Include the AHAX JavaScript Class.
 */
add_action('wp_head', 'ahax_add_js', 1);
function ahax_add_js() {
    wp_enqueue_script( 'ahaxJs', get_bloginfo('siteurl') . '/wp-content/plugins/ahax/ahax.js');
	wp_localize_script( 'ahaxJs', 'AHAXConfig', array( 'url' => get_bloginfo('siteurl') . '/wp-content/plugins/ahax/request.php' ) );
}
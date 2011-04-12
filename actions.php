<?php
/**
* Include the JS AHAX Mapper Class.
*/
add_action('wp_head', 'ahax_add_js', 1);
function ahax_add_js() {
    wp_enqueue_script( 'ahaxJs', get_bloginfo('siteurl') . '/wp-content/plugins/ahax/ahax.js', array('jquery'));
}
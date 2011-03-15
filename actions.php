<?php
/**
* Include the JS jquery ahax plugin.
*/
add_action('wp_head', 'add_ahax_js', 1);


function add_ahax_js() {
    wp_enqueue_script( 'ahaxJs', get_site_url() . '/wp-content/plugins/ahax/ahax.js', array('jquery'));
}
<?php
add_action('wp_loaded', 'af_custom_redirect');
function af_custom_redirect()
{	

	$request = $_SERVER['REQUEST_URI'];

	if (!is_user_logged_in() && !is_int(strpos($request, "/registrace")) && !is_int(strpos($request, "/vstup")) && !is_int(strpos($request, "/wp-login.php")) && !is_int(strpos($request, "/wp-json/"))) {
		wp_redirect(site_url("vstup"));
		exit;
	}
}


/* enqueue scripts and style from parent theme */
function twentytwenty_styles()
{
	wp_enqueue_style('parent', get_template_directory_uri() . '/style.css');
}
add_action('wp_enqueue_scripts', 'twentytwenty_styles');

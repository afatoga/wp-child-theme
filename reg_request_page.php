<?php /* Template Name: reg_request */


$isIE =
    preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) ||
    preg_match('~Trident/7.0(.*)?; rv:11.0~', $_SERVER['HTTP_USER_AGENT']);

if ($isIE) {
    wp_enqueue_script('unfetch-polyfill', 'https://unpkg.com/unfetch@4.2.0/polyfill/index.js');
}

wp_enqueue_script('af-custom', get_stylesheet_directory_uri().'/includes/custom.js', [], false, true);
wp_localize_script( 'af-custom', 'wpRestApi', [
    'root'  => esc_url_raw( rest_url().'aa_restserver/v1' )
] );

get_header(); ?>

<form name="registration" method="POST" onsubmit="return af_validateRequestForm(event);">

<label for="email">Email</label>
<input type="email" name="email" id="email">
<button type="submit">Odeslat žádost</button>
</form>

<?php get_footer(); ?>
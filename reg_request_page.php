<?php /* Template Name: reg_request */

if (is_user_logged_in()) wp_redirect(site_url());

$recaptchaSiteKey = "6LegGHYaAAAAAAvyBXcVrLC5GRlcWLxCVhKcI0Pq";
$isIE =
    preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) ||
    preg_match('~Trident/7.0(.*)?; rv:11.0~', $_SERVER['HTTP_USER_AGENT']);

if ($isIE) {
    wp_enqueue_script('unfetch-polyfill', 'https://unpkg.com/unfetch@4.2.0/polyfill/index.js');
}

wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js?render='.$recaptchaSiteKey, [], false, true);
wp_enqueue_script('af-custom', get_stylesheet_directory_uri().'/includes/custom.js', [], false, true);
wp_localize_script( 'af-custom', 'wpRestApi', [
    'root'  => esc_url_raw( rest_url().'aa_restserver/v1' ),
    'siteUrl' => site_url(),
    'recaptchaSiteKey' => $recaptchaSiteKey
] );

get_header(); ?>

<form name="registration" method="POST" style="width:600px; margin:2rem auto;">

<label for="first_name">Jméno</label>
<input type="text" name="first_name" id="first_name" required>
<br />
<label for="last_name">Příjmení</label>
<input type="text" name="last_name" id="last_name" required>
<br />
<label for="email">Email</label>
<input type="email" name="email" id="email" required>
<br />
<button 
        type="button"
        onclick='af_regForm_onSubmit(event)'
        >Odeslat žádost</button>
</form>

<?php get_footer(); ?>
<?php /* Template Name: reg_request */

if (is_user_logged_in()) wp_redirect(site_url());

$recaptchaSiteKey = "6LegGHYaAAAAAAvyBXcVrLC5GRlcWLxCVhKcI0Pq";
$isIE =
    preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) ||
    preg_match('~Trident/7.0(.*)?; rv:11.0~', $_SERVER['HTTP_USER_AGENT']);

if ($isIE) {
    wp_enqueue_script('unfetch-polyfill', 'https://unpkg.com/unfetch@4.2.0/polyfill/index.js');
}

wp_enqueue_script('pristine', get_stylesheet_directory_uri() . '/includes/pristine.min.js', [], false, true);

wp_enqueue_script('google-recaptcha', 'https://www.google.com/recaptcha/api.js?render=' . $recaptchaSiteKey, [], false, true);
wp_enqueue_script('af-custom', get_stylesheet_directory_uri() . '/includes/custom.js', [], false, true);
wp_localize_script('af-custom', 'wpRestApi', [
    'root'  => esc_url_raw(rest_url() . 'aa_restserver/v1'),
    'siteUrl' => site_url(),
    'recaptchaSiteKey' => $recaptchaSiteKey
]);

get_header(); ?>

<form name="registration" method="POST" style="width:600px; margin:2rem auto;">

    <div class="form-group">
        <label for="first_name">Jméno</label>
        <input type="text" name="first_name" id="first_name" required data-pristine-required-message="Toto pole je povinné"
        class="form-control">
    </div>
    <div class="form-group">
        <label for="last_name">Příjmení</label>
        <input type="text" name="last_name" id="last_name" required data-pristine-required-message="Toto pole je povinné"
        class="form-control">
    </div>
    <div class="form-group">
        <label for="department">Oddělení (nepovinné)</label>
        <input type="text" name="department" id="department"
        class="form-control">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required data-pristine-required-message="Toto pole je povinné" data-pristine-email-message="Zadejte validní email"
        class="form-control">
    </div>
    <div class="form-group">
        <label for="password">Heslo</label>
        <input type="password" name="password" id="password" 
        required
        data-pristine-required-message="Zvolte si heslo"
        class="form-control"
        >
    </div>
    <div class="form-group">
        <label for="password_retyped">Heslo znovu</label>
        <input type="password" name="password_retyped" id="password_retyped"
         data-pristine-equals="#password"
         data-pristine-equals-message="Hesla se neshodují"
         class="form-control">
    </div>
    <button type="button" onclick='af_regForm_onSubmit(event)'>Odeslat žádost</button>
</form>

<?php get_footer(); ?>
<?php

/* Template Name: af_login_page */

if (is_user_logged_in()) {
    return wp_redirect(site_url());
}

if (isset($_POST['login_form'])) {
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    $creds = array(
        'user_login'    => $login,
        'user_password' => $password,
        'remember'      => true
    );

    $user = wp_signon($creds, is_ssl());

    if (is_wp_error($user)) {
        $error = 'Nesprávné přihlašovací údaje';
    } else {
        wp_set_current_user($user->ID);
        return wp_redirect("/");
    }
} else if (isset($_POST['resetPw_check']) && !empty($_POST['resetPw_login'])) {
    $email = filter_var($_POST['resetPw_login'], FILTER_VALIDATE_EMAIL);

    if (!$email) $error = 'Nevalidní e-mail';
    else {
        $user_id = email_exists($email);
        af_send_password_reset($user_id);
    }
} else if (isset($_POST["password_retyped"]) && !empty($_POST['password'])) {

    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    $password_retyped = filter_var(trim($_POST['password_retyped']), FILTER_SANITIZE_STRING);

    $userLogin = filter_var(rawurldecode($_GET['login']), FILTER_SANITIZE_STRING);
    $reset = filter_var($_GET['reset'], FILTER_SANITIZE_STRING);

    if (!$password || $password !== $password_retyped) {
        $error = 'Heslo není validní';
    } else if (mb_strlen($password) < 6) {
        $error = 'Krátké heslo, zadejte minimálně 6 znaků';
    } else if (check_password_reset_key($reset, $userLogin)) {
        $user = get_user_by('email', $userLogin);
        wp_set_password($password, $user->ID);
        return wp_redirect("/login?akce=heslo-zmeneno");
    }
}

/*
    frontend
*/


wp_enqueue_script("pristine", get_stylesheet_directory_uri() . "/includes/pristine.min.js", [], false, true);
get_header();


// success or error alerts >
if (!empty($error)) {
    echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
}

if (isset($_GET['akce'])) {
    if ($_GET['akce'] === 'heslo-zmeneno') {
        echo '<div class="alert alert-success" role="alert">Heslo bylo změněno, můžete se přihlásit</div>';
    } else if ($_GET['akce'] === 'zadost-zmena-hesla') {
        echo '<div class="alert alert-success" role="alert">Na Váš e-mail byl zaslán odkaz pro změnu hesla</div>';
    }
}

// user forms bellow >

if (isset($_GET['akce']) && $_GET['akce'] === 'nastaveni-hesla') {
    get_template_part('/template-parts/login/set-pw', 'set-pw', []);
} else if (isset($_GET['akce']) && $_GET['akce'] === 'zapomenute-heslo') {
    get_template_part('/template-parts/login/lost-pw', "lost-pw", []);
} else {
    get_template_part('/template-parts/login/index', 'login-form', []);
}


get_footer();

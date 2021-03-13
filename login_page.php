<?php

/* Template Name: af_login_page */



if (is_user_logged_in()) {
    // return wp_redirect("/");
}

if(!empty($_POST['login']))
{
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_STRING);
    $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
    $creds = array(
        'user_login'    => $login,
        'user_password' => $password,
        'remember'      => true
    );

    $user = wp_signon($creds, is_ssl());

    if (is_wp_error($user))
    {
        $error = 'Nesprávné přihlašovací údaje';
    } else {
        wp_set_current_user($user->ID);
    }
}

if (!empty($_POST['resetPw_login']) && $_POST['resetPw_check'] === "") {
    $email = filter_var($_POST['resetPw_login'], FILTER_VALIDATE_EMAIL);


    if (!$email) $error = 'Nevalidní e-mail';
    else {
        $userId = email_exists($email);
        //if ($userId) af_sendPasswordResetMail($userId, false, "general");
        //header('Location: ' . get_site_url() . '/klient?akce=zadost-zmena-hesla');
    }

} else if (!empty($_POST['setPw_password'])) {
    $password = $_POST['setPw_password'];
    $userLogin = filter_var($_POST['setPw_login'], FILTER_SANITIZE_STRING);
    $reset = filter_var($_POST['setPw_reset'], FILTER_SANITIZE_STRING);

    if (mb_strlen(trim($password)) < 6) {
        $error = 'Krátké heslo, minimálně 6 znaků';
        echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
    } else if (check_password_reset_key($reset, $userLogin)) {
        $user = get_user_by('login', $userLogin);
        wp_set_password($password, $user->ID);
        return wp_redirect("/login?akce=heslo-zmeneno");
        //header('Location: ' . get_site_url() . '/login?akce=heslo-zmeneno');
    }
}

/*
    frontend
*/

get_header();

if (isset($_GET['akce']) && $_GET['akce'] === 'nastaveni-hesla')
{
        $user_login = filter_var(rawurldecode($_GET['login']), FILTER_SANITIZE_STRING);
        $reset = filter_var($_GET['reset'], FILTER_SANITIZE_STRING);

        if ($reset && $user_login && check_password_reset_key($_GET['reset'], $user_login))
        {
            get_template_part('/template-parts/login/set-pw', 'set-pw', ["user_login" => $user_login]);
        } else {
            $error = 'Chybný login';
            echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
        }

}

else if (isset($_GET['akce']) && $_GET['akce'] === 'zapomenute-heslo') {

    if (!empty($error)) {
        echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
    }

    get_template_part('/template-parts/login/lost-pw', "lost-pw", []);

} else {


    if (isset($_GET['akce'])) {
        if ($_GET['akce'] == 'heslo-zmeneno') {
            echo '<div class="alert alert-success" role="alert">Heslo bylo změněno, můžete se přihlásit</div>';
        } else if ($_GET['akce'] == 'zadost-zmena-hesla') {
            echo '<div class="alert alert-success" role="alert">Na Váš e-mail byl zaslán odkaz pro změnu hesla</div>';
        }
    }


    get_template_part('/template-parts/login/index', 'login-form', ["error" => $error]);

}
get_footer();

wp_enqueue_script("pristine", get_template_directory_uri() . "/includes/pristine.min.js", '', '', true);
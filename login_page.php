<?php

/* Template Name: af_login_page */

get_header();

if (!empty($_GET['akce']) && !empty($_GET['reset']))
{
    if ($_GET['akce'] == 'nastaveni-hesla' && !empty($_GET['login']))
    {
        $userLogin = filter_var(rawurldecode($_GET['login']), FILTER_SANITIZE_STRING);
        //$user = get_user_by('login', $userLogin);
        
        if (check_password_reset_key($_GET['reset'], $userLogin))
        {   
          ?> 
            <div class="col-lg-6 mx-auto af_customer_div_login">
                <h2>Nastavení hesla</h2>
                <form method="post" class="mt-4" id="af_customer_setPwForm">
                    <div class="form-group">
                        <input type="text" class="form-control af_customerFormInput" name="setPw_password" placeholder="nové heslo" required minlength="6">
                    </div>
                    <input type="hidden" name="setPw_reset" value="<?php echo htmlspecialchars($_GET['reset']); ?>">
                    <input type="hidden" name="setPw_login" value="<?php echo htmlspecialchars($userLogin); ?>">
                    <button type="submit" class="af_orderCourseButton btn btn-danger">Uložit</button>
                </form>
            </div>  
          <?php 
        } else {
            $error = 'Chybný login';
            echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
        }

    }

}

else if (!empty($_GET['zapomenute-heslo'])) {

    if (!empty($error)) {
        echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
    } ?>
    <div class="col-lg-6 mx-auto af_customer_div_login">
        <h2>Zapomenuté heslo</h2>
        <form method="post" class="mt-4" id="af_customer_resetPwForm">
            <div class="form-group">
                <input type="text" class="form-control af_customerFormInput" name="resetPw_login" placeholder="e-mail" required>
            </div>
            <input type="hidden" name="resetPw_check" value="">
            <button type="submit" class="af_orderCourseButton btn btn-danger">Odeslat</button>
        </form>
    </div>

<?php

} else {


    if (isset($_GET['akce'])) {
        if ($_GET['akce'] == 'heslo-zmeneno') {
            echo '<div class="alert alert-success" role="alert">Heslo bylo změněno, můžete se přihlásit</div>';
        } else if ($_GET['akce'] == 'zadost-zmena-hesla') {
            echo '<div class="alert alert-success" role="alert">Na Váš e-mail byl zaslán odkaz pro změnu hesla</div>';
        }
    }

?>
    <div class="col-lg-6 mx-auto af_customer_div_login">
        <?php if (!empty($error)) : ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
        <h2>Přihlášení</h2>
        <form method="post" class="mt-4" id="af_customer_loginForm" name="customer_loginForm">
            <div class="form-group">
                <input type="text" class="form-control af_customerFormInput" name="login" id="af_customer_loginForm_login" placeholder="e-mail" data-pristine-required-message="Toto pole je povinné">
            </div>
            <div class="form-group">
                <input type="password" class="form-control af_customerFormInput" name="password" id="af_customer_loginForm_password" placeholder="heslo" data-pristine-required-message="Toto pole je povinné">
            </div>
            <button type="submit" class="af_orderCourseButton btn btn-danger">Přihlásit se</button>
        </form>
        <a class="af_courseLink" href="<?php echo get_site_url(); ?>/login?zapomenute-heslo">
            <p class="mt-4"><u>Zapomenuté heslo</u></p>
        </a>

        <p>Nedaří se Vám přihlásit dříve založeným účtem? Kontaktujte nás na jsme@lifesupport.cz</p>

    </div>

<?php
}
get_footer();

wp_enqueue_script("pristine", get_template_directory_uri() . "/includes/pristine.min.js", '', '', true);
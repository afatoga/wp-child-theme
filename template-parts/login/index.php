

<div class="col-lg-6 mx-auto af_customer_div_login">
    <?php if (isset($args["error"]) && !empty($args["error"])) : ?><div class="alert alert-danger"><?php echo $args["error"] ?></div><?php endif; ?>
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
    <a class="" href="<?php echo get_site_url(null, "/login?akce=zapomenute-heslo"); ?>">
        <p class="mt-4"><u>Zapomenuté heslo</u></p>
    </a>

    <p>Nedaří se Vám přihlásit dříve založeným účtem? Kontaktujte nás na jsme@vize.cz</p>

</div>
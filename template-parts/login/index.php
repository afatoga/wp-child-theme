<div>
    <h2>Přihlášení</h2>
    <form method="post" class="mt-4" id="login_form">
        <div class="form-group">
            <input type="email" class="form-control" name="login" placeholder="e-mail" required data-pristine-required-message="Toto pole je povinné">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="heslo" required data-pristine-required-message="Toto pole je povinné">
        </div>
        <button type="submit" name="login_form">Přihlásit se</button>
    </form>
    <a class="" href="<?php echo get_site_url(null, "/" . $args["page_slug"]. "?akce=zapomenute-heslo"); ?>">
        <p class="mt-4"><u>Zapomenuté heslo</u></p>
    </a>

    <p>Nedaří se Vám přihlásit dříve založeným účtem? Kontaktujte nás na jsme@vize.cz</p>

</div>
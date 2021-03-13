<div class="col-lg-6 mx-auto af_customer_div_login">
    <h2>Nastavení hesla</h2>
    <form method="post" class="mt-4" id="af_customer_setPwForm">
        <div class="form-group">
            <input type="text" class="form-control af_customerFormInput" name="setPw_password" placeholder="nové heslo" required minlength="6">
        </div>
        <input type="hidden" name="setPw_reset" value="<?php echo htmlspecialchars($_GET['reset']); ?>">
        <input type="hidden" name="setPw_login" value="<?php echo htmlspecialchars($args["user_login"]); ?>">
        <button type="submit" class="af_orderCourseButton btn btn-danger">Uložit</button>
    </form>
</div>
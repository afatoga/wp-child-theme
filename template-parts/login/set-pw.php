<div class="col-lg-6 mx-auto af_customer_div_login">
    <h2>Nastavení hesla</h2>
    <form method="post" class="mt-4" name="reset_password">
        <div class="form-group">
        <label for="password">Heslo</label>
            <input type="password" class="form-control" name="password" id="password"
            required
            minlength="6"
            data-pristine-minlength-message="Heslo musí obsahovat minimálně 6 znaků"
            data-pristine-required-message="Zvolte si heslo">
        </div>
        <div class="form-group">
        <label for="password_retyped">Heslo znovu</label>
            <input type="password" class="form-control" name="password_retyped" id="password_retyped"
            data-pristine-equals="#password"
         data-pristine-equals-message="Hesla se neshodují">
        </div>
        <button type="submit" onclick='af_passResetForm_onSubmit(event)'>Uložit</button>
    </form>
</div>

<script>

    function af_passResetForm_onSubmit(event) {

    event.preventDefault()
    const form = document.querySelector("form[name='reset_password']")
    const pristine = new Pristine(form)
    const valid = pristine.validate()

    if (!valid) return false
    form.submit()
}

</script>
function af_regForm_onSubmit(event) {
  event.preventDefault();
  const form = document.querySelector("form[name='registration']")

  // const pristineConfig = {
  //   // class of the parent element where the error/success class is added
  //   classTo: 'form-group',
  //   errorClass: 'has-danger',
  //   successClass: 'has-success',
  //   // class of the parent element where error text element is appended
  //   errorTextParent: 'form-group',
  //   // type of element to create for the error text
  //   errorTextTag: 'div',
  //   // class of the error text element
  //   errorTextClass: 'text-help'
  // }

  const pristine = new Pristine(form)
  //if (!form.checkValidity()) return form.reportValidity() // html validation
  const valid = pristine.validate()

  if (!valid) return false;
  const data = new FormData(form)
  //return  af_sendRequest("/submit_registration_form", data, "/zadost-odeslana", pristine);

  grecaptcha.ready(function () {
    grecaptcha
      .execute(wpRestApi.recaptchaSiteKey, { action: "submit" })
      .then(function (token) {
        data.append("g-recaptcha-response", token);

        af_sendRequest("/submit_registration_form", data, "/zadost-odeslana", pristine);
      });
  });
}

function af_sendRequest(apiRoute, data, redirect, pristine) {
  fetch(wpRestApi.root + apiRoute, {
    method: "POST",
    body: data,
    headers: {
      Accept: "application/json",
    },
  })
    .then(function (response) {
      if (response.ok) {
        const userEmail = data.get("email");
        if (redirect.length)
          return window.location.replace(
            wpRestApi.siteUrl + redirect + "?email=" + userEmail
          );
        return response.json();
      }
      return Promise.reject(response);
    })
    // .then(function (data) {
    //   console.log(data);
    // })
    .catch(function (error) {

      error.json().then(function (response) {

        if (response.code === "invalid_recaptcha") return alert("Nevalidní recaptcha")

        pristine.addError(document.getElementById(response.data.payload_item), response.message)
      })
    });
}

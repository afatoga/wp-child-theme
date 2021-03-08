function af_regForm_onSubmit(event) {
  event.preventDefault()
  const form = document.querySelector("form[name='registration']")
  if (!form.checkValidity()) return form.reportValidity();

  const data = new FormData(form)

  if (!data.get("email").length) return false



  grecaptcha.ready(function () {
    grecaptcha
      .execute(wpRestApi.recaptchaSiteKey, { action: "submit" })
      .then(function (token) {
        data.append("g-recaptcha-response", token)

        af_sendRequest("/submit_registration_form", data, "/zadost-odeslana")
      })
  })
}

function af_sendRequest(apiRoute, data, redirect) {
  fetch(wpRestApi.root + apiRoute, {
    method: "POST",
    body: data,
    headers: {
      Accept: "application/json",
    },
  })
    .then(function (response) {
      if (response.ok) {
        const userEmail = data.get("email")
        if(redirect.length) return window.location.replace(wpRestApi.siteUrl+redirect+'?email='+userEmail)
        return response.json()
      }
      return Promise.reject(response)
    })
    .then(function (data) {
      console.log(data)
    })
    .catch(function (error) {
      console.warn(error)
    })
}

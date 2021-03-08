function af_regForm_onSubmit(event) {

  const form = document.querySelector("form[name='registration']")
  if (!form.checkValidity()) return;

  const data = new FormData(form)

  if (!data.get("email").length) return false

  event.preventDefault()

  grecaptcha.ready(function () {
    grecaptcha
      .execute(wpRestApi.recaptchaSiteKey, { action: "submit" })
      .then(function (token) {
        data.append("g-recaptcha-response", token)

        af_sendRequest("/submit_registration_form", data)
      })
  })
}

function af_sendRequest(apiRoute, data) {
  fetch(wpRestApi.root + apiRoute, {
    method: "POST",
    body: data,
    headers: {
      Accept: "application/json",
    },
  })
    .then(function (response) {
      if (response.ok) {
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

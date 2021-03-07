function af_validateRequestForm(event) {
  event.preventDefault()
  //const form = document.querySelector("form[name='registration']")
  const data = new FormData(event.target)
    
  if (!data.get("email").length) return false

	fetch(wpRestApi.root + "/submit_registration_form", {
		method: 'POST',
		body: new FormData(event.target),
        headers: {
            'Accept': 'application/json'
        },
	}).then(function (response) {
		if (response.ok) {
			return response.json();
		}
		return Promise.reject(response);
	}).then(function (data) {
		console.log(data);
	}).catch(function (error) {
		console.warn(error);
	});
}
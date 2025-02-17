// Signup JS
let SignupForm = document.querySelector(".signup-form");

SignupForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  let userName = SignupForm.querySelector("#user-name").value.toLowerCase();
  let email = SignupForm.querySelector("#email").value.trim();
  let password = SignupForm.querySelector("#password").value;
  let confirmPass = SignupForm.querySelector("#confirm-password").value;

  const formData = {
    userName: userName,
    email: email,
    password: password,
    confirmPass: confirmPass,
  };

  console.log(formData);

  const url = "../../app/controllers/registerUserController.php";

  let d = await ajax(url, "post", formData, {'Content-type':'application/json'});
  response = await d.json();

  console.log(d);
  console.log(response);


  console.log(response.msg);
  console.log(response.status);
  console.log(response.data);
  console.log(response.redirect);

  showToast(response.msg, response.status);

  if (response.status == "success") {
        showToast(response.msg, response.status);
        setTimeout(() => {
            window.location.href = response.redirect;
        }, 1500);
    } else {
        showToast(response.msg, response.status);
    }
});
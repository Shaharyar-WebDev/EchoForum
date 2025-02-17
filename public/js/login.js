let loginForm = document.querySelector(".login-form");

loginForm.addEventListener("submit", async (e) => {

    e.preventDefault();

    let email = loginForm.querySelector("#email").value.trim();
    let password = loginForm.querySelector("#password").value;

    const formData = {
        email: email,
        password: password
    };

    console.log(formData);

    const url = "../../app/controllers/loginUserController.php";

    let d = await ajax(url, "post", formData, {
        'Content-type': 'application/json'
    });
    response = await d.json();

    console.log(d);
    console.log(response);

    console.log(response.msg);
    console.log(response.status);
    console.log(response.redirect);

    if (response.status == "success") {
        showToast(response.msg, response.status);
        setTimeout(() => {
            window.location.href = response.redirect;
        }, 1500);
    } else {
        showToast(response.msg, response.status);
    }

});
import {
  RECAPTCHA_PUBLIC_KEY,
  formLogin,
  btnLogin,
  txtEmail,
  txtPassword,
} from "./variables";

document.addEventListener("DOMContentLoaded", (e) => {
  btnLogin.addEventListener("click", (e) => {
    e.preventDefault();

    let email = txtEmail.value.toString() || "";
    let password = txtPassword.value.toString() || "";

    if (email.trim().length == 0) {
      txtEmail.focus();
    } else {
      if (password.trim().length == 0) {
        txtPassword.focus();
      } else {
        grecaptcha.ready(function () {
          btnLogin.disabled = true;
          btnLogin.innerHTML = "Verifying recaptcha...";

          grecaptcha
            .execute(RECAPTCHA_PUBLIC_KEY, { action: "submit" })
            .then(function (token) {
              btnLogin.innerHTML = "Verifying credentials...";
              formLogin.submit();
            });
        });
      }
    }
  });
});

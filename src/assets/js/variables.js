
//Envs
const RECAPTCHA_PUBLIC_KEY = process.env.RECAPTCHA_PUBLIC_KEY;


//Login page
const formLogin = document.getElementById("login-form");
const btnLogin = document.getElementById("login-submit");
const txtEmail = document.getElementById("email");
const txtPassword = document.getElementById("password");


module.exports = {

  RECAPTCHA_PUBLIC_KEY,

  formLogin,
  btnLogin,
  txtEmail,
  txtPassword,
};

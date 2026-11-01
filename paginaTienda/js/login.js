//login js

const loginForm = document.querySelector(".login");
const registerForm = document.querySelector(".register");
const toggle = document.querySelector(".toggle");

const toggleView = (next) => {

    //toggle indicator
    toggle.classList.toggle("login_active", next === "login");

    //reset forms
    [(loginForm, registerForm)].forEach((element) => element.classList.remove("active"),);

    //toggle active class
    loginForm.classList.toggle("active", next === "login");
    registerForm.classList.toggle("active", next === "register");

};
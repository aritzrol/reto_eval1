//login js


//elemtos del HTML
const buttonLogin = document.getElementById("button_login");
const buttonRegister = document.getElementById("button_create");
const coverImage = document.querySelector(".cover-image");


//LISTENERS
buttonRegister.addEventListener("click", function(){

    console.log("click en register");
    coverImage.classList.add("cover-left");

});

buttonLogin.addEventListener("click", function(){

    coverImage.classList.remove("cover-left");
    
});
// Applies the saved theme and lets you change it from the navbar icon.
// const darkModeIcon = document.querySelector('nav img[src*="darkMode_icon.png"]');
const darkModeIcon = document.getElementById("dark-mode-icon");
const navUserIcon = document.getElementById("user-icon");
const navCartIcon = document.getElementById("cart-icon");

darkMode();
userLogin();
cartView();

function darkMode(){
    if (localStorage.getItem("darkMode") === "true") {
    document.body.classList.add("dark-mode");
    }

    if (darkModeIcon !== null) {
        const darkModeButton = darkModeIcon.closest("a");

        updateDarkModeIcon();

        darkModeButton.addEventListener("click", function (event) {
            event.preventDefault();

            document.body.classList.toggle("dark-mode");
            localStorage.setItem("darkMode", document.body.classList.contains("dark-mode"));
            updateDarkModeIcon();
        });
    }
}

// Changes the icon depending on the current mode: dia.svg in day mode, noche.svg in night mode.
function updateDarkModeIcon(){
    if (document.body.classList.contains("dark-mode")) {
        darkModeIcon.src = "IMG/icons/noche.svg";
        darkModeIcon.alt = "Night mode";
    } else {
        darkModeIcon.src = "IMG/icons/dia.svg";
        darkModeIcon.alt = "Day mode";
    }
}


function userLogin(){
    // check if localStorage has a logged user
    const loggedUser = JSON.parse(localStorage.getItem("loggedUser"));

    // Now the data is ready, check if a user is logged
    if (loggedUser) {

        //Change the user icon to LOG IN (green)
        navUserIcon.classList.add("user-icon");
    }else{
        
        navUserIcon.classList.remove("user-icon");
    }
}

function cartView(){
    
    // no icon on this page, nothing to do
    if(navCartIcon === null) return;

    //Check localStorage if any products exists
    let cartStorage = JSON.parse(localStorage.getItem("cart")) || [];

    if(cartStorage.length > 0){
        navCartIcon.classList.add("cart-icon");      
    }else{
        navCartIcon.classList.remove("cart-icon");  
    }
    
}
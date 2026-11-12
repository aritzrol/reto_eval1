
//JSON SERVER URL
const API_URL_USUARIOS = "http://localhost:3000/usuarios";
const API_URL_PEDIDOS = "http://localhost:3000/pedidos";

//FUNCTION TO START THE PAGE
async function init(){

    // Wait until users and orders are loaded
    await Promise.all([fetchUsers(), fetchOrders()]);

    // check if localStorage has a logged user
    const loggedUser = JSON.parse(localStorage.getItem("loggedUser"));



    // Now the data is ready, check if a user is logged
    if (loggedUser) {
        customerArea.classList.add("customer-area-loged");
        forms.style.display = "none";
        logoutButton.style.display = "block";
        showOrders(loggedUser.id);

        // //Change the user icon to LOG IN (green)
        // userIcon.classList.add("user-icon");
    }
}

// Call the init function and handle errors
init().catch(error => console.error("Error loading the data", error));

//HTML ELEMENTS
let users = [];
let orders = [];
const alertBox = document.getElementById("alert");
const forms = document.querySelector(".card");
const customerArea = document.querySelector(".customer-area");
const buttonLogin = document.getElementById("button_login");
const buttonRegister = document.getElementById("button_create");
const coverImage = document.querySelector(".cover-image");
const loginEmail = document.getElementById("login-email");
const loginPassword = document.getElementById("login-password");
const loginButton = document.getElementById("loginButton");
const logoutButton = document.getElementById("logoutButton");
const registerButton = document.getElementById("registerButton");
const registerName = document.getElementById("register-name");
const registerEmail = document.getElementById("register-email");
const registerPassword = document.getElementById("register-password");
const userIcon = document.getElementById("user-icon");
const cartIcon = document.getElementById("cart-icon");

//FUNCTIONS
async function fetchUsers(){
    
    const response = await fetch(API_URL_USUARIOS);

    if(!response.ok){
        throw new Error("The users could not be loaded");
    }

    users = await response.json();

}

async function fetchOrders(){
    const response = await fetch(API_URL_PEDIDOS);

    if(!response.ok){
        throw new Error("The orders could not be loaded");
    }

    orders = await response.json();
}

async function registerUser(newId, newName, newEmail, newPassword){

    const newUser = {
        id: newId,
        name: newName,
        email: newEmail,
        password: newPassword
    }

    const response = await fetch(API_URL_USUARIOS, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(newUser)
    });

    if(!response.ok){
        throw new Error("The user could not be registered");
    }

    const createdUser = await response.json();
    
    return createdUser;
}

//FUNCTION TO SHOW ORDERS
function showOrders(id){

    console.log(id);

    console.log("Orders before filtering:", orders);

    clearOrders(); // Clear previous orders before showing new ones

    console.log("Orders after filtering:", orders);

    const userOrders = orders.filter((order) => order.id_usuario == id);

    console.log("User Orders:", userOrders);

    userOrders.forEach((order) => {

        console.log("entered the foreach");

        //1 order - 1 card
        const orderCard = document.createElement("div");
        orderCard.classList.add("order-card");

        // 1. We start with an empty text
        let productsHTML = "";

        // 2. We go through the products of THIS order
        order.productos.forEach((p) => {
            // 3. For each product, we add a line to the text
            productsHTML = productsHTML + "<li>" + p.name + " " + p.number + " x " + p.quantity + "</li>";
        });


        //Order details
        // 4. We put the finished text into the card
        orderCard.innerHTML = `
            <h3>Order:</h3>
            <ul>${productsHTML}</ul>
            <p>Date Order: ${order.fecha}</p>
            <p>Total €: ${order.total}</p>
            <span class="order-status ${order.estado.toLowerCase()}">${order.estado}</span>
        `;

        customerArea.appendChild(orderCard);

    });

}

//function to clear orders
function clearOrders(){
    const oldCards = document.querySelectorAll(".order-card");

    oldCards.forEach((card) => {
        card.remove();
    });
}

//function to clean the login form
function cleanLoginForm(){
    loginEmail.value = "";
    loginPassword.value = "";
}

//function to create the alert message
function newAlert(text, icon){

    alertBox.innerHTML = "";

    const box = document.createElement("div");
    box.classList.add("textAlert");

    box.innerHTML = `
        <span>${icon}</span>
        <p>ALERT : ${text}</p>
    `;

    alertBox.appendChild(box);

    alertBox.style.display = "block";
}


//LISTENERS

//IMAGE MOVEMENT / LOGIN AND REGISTER BUTTONS

//==========================
//LOGIN
//==========================
buttonRegister.addEventListener("click", function(){

    console.log("click on register");
    coverImage.classList.add("cover-left");

});

buttonLogin.addEventListener("click", function(){

    coverImage.classList.remove("cover-left");
    
});

//LOGIN BUTTON
loginButton.addEventListener("click", function(event){

    event.preventDefault();

    let email = loginEmail.value;
    let password = loginPassword.value;

    //alerts for empty fields
    if(email.trim() === ""){
        
        text = "Check EMAIL!";
        newAlert(text, "!");

        return;
    }

    if(password.trim() === ""){
        
        text = "Check PASSWORD!";
        newAlert(text, "!");

        return;
    }
    
    // Check if the user exists in the users array
    const user = users.find((user) => email === user.email && password === user.password);

    console.log(user);
    // If the user exists, log in and show the customer area
    if (user) {

        // Store the logged-in user information in localStorage
        localStorage.setItem("loggedUser", JSON.stringify({
            id: user.id,
            name: user.name,
            email: user.email
        }));

        console.log("Login successful");
        customerArea.classList.add("customer-area-loged");
        forms.style.display = "none";

        // Show the orders for the logged-in user
        console.log("User ID:", user.id);
        showOrders(user.id);

        // Show the logout button
        logoutButton.style.display = "block"; 

        //Change the user icon to LOG IN (green)
        userIcon.classList.add("user-icon");

        // Clear the login form after successful login
        cleanLoginForm(); 
    }else{
        console.log("Login failed");
        
        text = "Login failed!!!";
        newAlert(text, "X");
    }
    
    console.log(orders);

});

//LOGOUT BUTTON
logoutButton.addEventListener("click", function(event){
    event.preventDefault();

    // Remove the logged-in user information from localStorage
    localStorage.removeItem("loggedUser");

    //remove the order cards
    clearOrders();

    // Hide the customer area and show the login form
    customerArea.classList.remove("customer-area-loged");
    forms.style.display = "block";
    // Hide the logout button
    logoutButton.style.display = "none"; 

    //change user icon color to none
    userIcon.classList.remove("user-icon");

});

//==========================
//REGISTER
//==========================


//REGISTER BUTTON
registerButton.addEventListener("click", function(event){

    let text = "";

    event.preventDefault();

    //User data
    let newName = registerName.value;
    let newEmail = registerEmail.value;
    let newPassword = registerPassword.value;

    //new id for the new user
    let newId = users.length > 0 ? users[users.length - 1].id + 1 : 1;

    console.log("this is the id created on purpose", newId);

    //alerts for empty fields
    if(newName.trim() === ""){

        text = "Check NAME!!!";

        newAlert(text, "!");
        
        return;
    }

    if(newEmail.trim() === ""){
        
        text = "Check EMAIL!!!";
        newAlert(text, "!");

        return;
    }

    if(newPassword.trim() === ""){
        
        text = "Put a PASSWORD!!!";
        newAlert(text, "!");

        return;
    }

    // Check if the email is already registered
    const userRegistered = users.find((user) => user.email === newEmail); //for later

    if(userRegistered){
        text = "THAT EMAIL ALREADY EXISTS!";
        newAlert(text, "X");

        return;
    }

    //use function to create new user
    const createdUser = registerUser(newId, newName, newEmail, newPassword);

    //OK ALERT
    if(createdUser){
        // let text = "USER ADDED SUCCESSFULLY";
        // newAlert(text);
        alert("user added");
    }

});

//HIDE ALERT
alertBox.addEventListener("click", function(){

    alertBox.style.display = "none";
});


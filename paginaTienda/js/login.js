
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
    }
}

// Call the init function and handle errors
init().catch(error => console.error("Error al cargar los datos", error));

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


//FUNCTIONS
async function fetchUsers(){
    
    const response = await fetch(API_URL_USUARIOS);

    if(!response.ok){
        throw new Error("No se pudieron cargar los usuarios");
    }

    users = await response.json();

}

async function fetchOrders(){
    const response = await fetch(API_URL_PEDIDOS);

    if(!response.ok){
        throw new Error("No se pudieron cargar los pedidos");
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
        throw new Error("No se pudo registrar el usuario");
    }

    const createdUser = await response.json();
    
    return createdUser;
}

//FUNCTION TO SHOW ORDERS
function showOrders(id){

    console.log(id);

    console.log("Orders antes de filtrar:", orders);

    clearOrders(); // Clear previous orders before showing new ones

    console.log("Orders despues de filtrar:", orders);

    const userOrders = orders.filter((order) => order.id_usuario == id);

    console.log("User Orders:", userOrders);

    userOrders.forEach((order) => {

        console.log("ha entrado en el foreach");

        //1 order - 1 card
        const orderCard = document.createElement("div");
        orderCard.classList.add("order-card");

        //Order details
        orderCard.innerHTML = `
            <h3>Order: ${order.id}</h3>
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
function newAlert(text){

    alertBox.innerHTML = "";

    const box = document.createElement("div");
    box.classList.add("textAlert");

    box.innerHTML = `
        <p>ALERT:<br> ${text}</p>
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

    console.log("click en register");
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
        
        text = "Put your LOGIN EMAIL!!!";
        newAlert(text);

        return;
    }

    if(password.trim() === ""){
        
        text = "Put your PASSWORD!!!";
        newAlert(text);

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

        logoutButton.style.display = "block"; // Show the logout button

        cleanLoginForm(); // Clear the login form after successful login
    }else{
        console.log("Login failed");
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
    logoutButton.style.display = "none"; // Hide the logout button

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

    console.log("este es el id creado aproposito", newId);

    //alerts for empty fields
    if(newName.trim() === ""){

        text = "Put your NAME!!!";

        newAlert(text);
        
        return;
    }

    if(newEmail.trim() === ""){
        
        text = "Put an EMAIL!!!";
        newAlert(text);

        return;
    }

    if(newPassword.trim() === ""){
        
        text = "Put a PASSWORD!!!";
        newAlert(text);

        return;
    }

    // Check if the email is already registered
    const userRegistered = users.find((user) => user.email === newEmail); //pa luego

    if(userRegistered){
        text = "THAT EMAIL ALREADY EXISTS!!!";
        newAlert(text);

        return;
    }

    //use function to create new user
    const createdUser = registerUser(newId, newName, newEmail, newPassword);

    //OK ALERT
    if(createdUser){
        // let text = "USUARIO AÑADIDO CORRECTAMENTE";
        // newAlert(text);
        alert("usuario añadido");
    }

});

//HIDE ALERT
alertBox.addEventListener("click", function(){

    alertBox.style.display = "none";
});


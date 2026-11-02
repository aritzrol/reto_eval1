
//JSON SERVER URL
const API_URL_USUARIOS = "http://localhost:3000/usuarios";
const API_URL_PEDIDOS = "http://localhost:3000/pedidos";

//FIRST TIME PAGE LOAD
fetchUsers().catch(error => console.error("Error al obtener los usuarios", error));
fetchOrders().catch(error => console.error("Error al obtener los pedidos", error));

//HTML ELEMENTS
let users = [];
let orders = [];
const forms = document.querySelector(".card");
const customerArea = document.querySelector(".customer-area");
const buttonLogin = document.getElementById("button_login");
const buttonRegister = document.getElementById("button_create");
const coverImage = document.querySelector(".cover-image");
const loginEmail = document.getElementById("login-email");
const loginPassword = document.getElementById("login-password");
const loginButton = document.getElementById("loginButton");
const logoutButton = document.getElementById("logoutButton");

// Check if a user is already logged in
const loggedUser = JSON.parse(localStorage.getItem("loggedUser"));

console.log("Logged User:", loggedUser.id_usuario);

if (loggedUser) {
    customerArea.classList.add("customer-area-loged");
    forms.style.display = "none";
    showOrders(loggedUser.id_usuario);
}


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

//FUNCTIO TO SHOW ORDERS
function showOrders(id_user){

    clearOrders(); // Clear previous orders before showing new ones

    const userOrders = orders.filter((order) => order.id_usuario === id_user);

    userOrders.forEach((order) => {

        //1 order - 1 card
        const orderCard = document.createElement("div");
        orderCard.classList.add("order-card");

        //Order details
        orderCard.innerHTML = `
            <h3>Order: ${order.id_pedido}</h3>
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




//LISTENERS

//IMAGE MOVEMENT / LOGIN AND REGISTER BUTTONS
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

    // Find the user with the provided email and password
    console.log(email, password);
    
    // Check if the user exists in the users array
    const user = users.find((user) => email === user.email && password === user.password);

    console.log(user);
    // If the user exists, log in and show the customer area
    if (user) {

        // Store the logged-in user information in localStorage
        localStorage.setItem("loggedUser", JSON.stringify({
            id_usuario: user.id_usuario,
            name: user.name,
            email: user.email
        }));

        console.log("Login successful");
        customerArea.classList.add("customer-area-loged");
        forms.style.display = "none";

        // Show the orders for the logged-in user
        console.log("User ID:", user.id_usuario);
        showOrders(user.id_usuario);

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
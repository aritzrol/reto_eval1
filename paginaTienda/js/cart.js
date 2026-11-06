//JSON SERVER URL
const API_URL_USUARIOS = "http://localhost:3000/usuarios";
const API_URL_PEDIDOS = "http://localhost:3000/pedidos";

//FUNCTION TO START THE PAGE
let loggedUser = [];

async function init(){

    // Wait until users and orders are loaded
    await Promise.all([fetchUsers(), fetchOrders()]);

    // check if localStorage has a logged user
    loggedUser = JSON.parse(localStorage.getItem("loggedUser"));

}

// Call the init function and handle errors
init().catch(error => console.error("Error al cargar los datos", error));

//se lee el localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

console.log(cart);

//variables html
const cartBox = document.getElementById("cart-items");
const deleteButtons = document.getElementsByClassName("delete-button");
const standardRadio = document.getElementById("standard-radio");
const expressRadio = document.getElementById("express-radio");
const totalPrice = document.getElementById("summary-total");
const buyButton = document.getElementById("checkout-button");

//variables
let standardShipping = true;
let expressShipping = false;
let standarPrice = 3.95;
let expressPrice = 6.95;
let total = 0;


console.log(standardRadio.checked);
priceCalculator();

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

//CREATE THE PRODUCT CARDS
cart.forEach((product) => {

    const productCard = document.createElement("div");
    productCard.classList.add("product-card");

    const subtotal = product.quantity * product.price;
    //card details
    productCard.innerHTML = `
        <span>${product.name}</span>
        <span>${product.price}</span>
        <span>${product.quantity}</span>
        <span>${subtotal}</span>  
        <button class="delete-button">🗑</button>
        <p style="display: none;">${product.id}</p>
    `;

    //ADD ONE PROCUCT TO THE BOX
    cartBox.appendChild(productCard);
});

//PRICE CALCULATOR
function priceCalculator(){

    total = 0;

    cart.forEach((product) => {

        total = total + (product.price * product.quantity);
        
    });

    //SHIPPING PRICE ONLY ONCE
    if (cart.length > 0) {

        const shipping = expressRadio.checked ? expressPrice : standarPrice;
        total = total + shipping;

    }

    totalPrice.textContent = total.toFixed(2) + " €";

}

//LISTENERS

//BUY BUTTON
buyButton.addEventListener("click", function(){

    // Check if a user is logged
    if (!loggedUser) {
        console.log("usuario lno ogeado");
        return;
    }

    console.log("has pulsado en comprar");

    console.log(totalPrice.textContent);

    //EMPTY CART, NOTHING TO BUY
    if(cart.length === 0){
        return;
    }


});

async function registerProduct(id_usuario, cart){

    const newOrder = {
        id_usuario: loggedUser.id,
        fecha: new Date().toISOString().split("T")[0],
        total: Number(total.toFixed(2)),
        estado: "pendiente de envio",
        producto: cart
    };

    fetch(API_URL_PEDIDOS, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(newOrder)
    });

    if(!response.ok){
        throw new Error("No se pudo registrar el pedido");
    }

    const createdProduct = await response.json();
    
    // return createdProduct;
    console.log(createdProduct);
}


//DELETE PRODUCTS 
for(let i=0; i < deleteButtons.length; i++){

    deleteButtons[i].addEventListener("click", function(event){

        console.log("boton borrar");

        event.preventDefault();

        const id = event.currentTarget.nextElementSibling.textContent;

        console.log(id);

        //remove product from localStorage
        //new array "cart" without this element
        cart = cart.filter((product) => product.id !== Number(id));
        
        //replace de array in localStorage
        localStorage.setItem("cart", JSON.stringify(cart));

        //remove this card
        event.currentTarget.parentElement.remove();

        //recalculated price
        priceCalculator();
    
    });
}

//RADIO BUTTONS
standardRadio.addEventListener("change", function(){

    total = 0;
    // standardShipping = true;
    // expressShipping = false;

    priceCalculator(standarPrice);

    // cart.forEach((product) => {

    //     total = total + product.price;
        
    // });

    // console.log(total + standarPrice);
});

expressRadio.addEventListener("change", function(){

    total = 0;
    // expressShipping = true;
    // standardShipping = false;

    priceCalculator(expressPrice);

    // cart.forEach((product) => {

    //     total = total + product.price;
        
    // });

    // console.log(total + expressPrice);
});




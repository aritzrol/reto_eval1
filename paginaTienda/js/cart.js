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
init().catch(error => console.error("Error loading the data", error));

//read the localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];


console.log(cart);

//html variables
const cartBox = document.getElementById("cart-items");
const deleteButtons = document.getElementsByClassName("delete-button");
const standardRadio = document.getElementById("standard-radio");
const expressRadio = document.getElementById("express-radio");
const totalPrice = document.getElementById("summary-total");
const buyButton = document.getElementById("checkout-button");
const zeroProductsImage = document.getElementById("empty-cart");
const alertBox = document.getElementById("alert");
const cartIcon = document.getElementById("cart-icon");

//variables
let users = [];
let orders = [];
let standardShipping = true;
let expressShipping = false;
let standarPrice = 3.95;
let expressPrice = 6.95;
let total = 0;


console.log(standardRadio.checked);
emptyCart();
showProducts();
priceCalculator();

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

function emptyCart(){

    if(cart.length === 0){
        zeroProductsImage.style.display = "block";
    }else{
        zeroProductsImage.style.display = "none";
    }
    
}

//CREATE THE PRODUCT CARDS
function showProducts(){

    cart.forEach((product) => {


        const productCard = document.createElement("div");
        productCard.classList.add("product-card");

        const subtotal = product.quantity * product.price;
        //card details
        productCard.innerHTML = `
            <span>${product.name} - ${product.number}</span>
            <span>${product.price}</span>
            <span>${product.quantity}</span>
            <span>${subtotal}</span>  
            <button class="delete-button">🗑</button>
            <p style="display: none;">${product.id}</p>
        `;

        //ADD ONE PROCUCT TO THE BOX
        cartBox.appendChild(productCard);
    });
}

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

//CART LIGHT
function cartView(){
    
    // no icon on this page, nothing to do
    if(cartIcon === null) return;

    //Check localStorage if any products exists
    let cartStorage = JSON.parse(localStorage.getItem("cart")) || [];

    if(cartStorage.length > 0){
        cartIcon.classList.add("cart-icon");      
    }else{
        cartIcon.classList.remove("cart-icon");  
    }
    
}

//LISTENERS

//BUY BUTTON
buyButton.addEventListener("click", function(event){

    event.preventDefault();

    //EMPTY CART, NOTHING TO BUY
    if(cart.length === 0){

        text = "EMPTY CART!";
        newAlert(text, "!");
        return;
    }

    // Check if a user is logged
    if (!loggedUser) {
        console.log("user not logged in");
        text = "user not logged in!!!";
        newAlert(text, "X");

        return;
    }

    const user_id = loggedUser.id;

    //function to save products order in the json
    
    saveCart(user_id, cart);

    alert("ORDER PLACED SUCCESSFULLY");

    //remove products from localStorage
    //new array "cart" with 0 elements
    cart = [];
        
    //replace de array in localStorage
    localStorage.setItem("cart", JSON.stringify(cart));

    priceCalculator();

    emptyCart();

});

async function saveCart(user_id, cart){

    let newId = orders.length > 0 ? orders[orders.length - 1].id + 1 : 1;

    const newOrder = {
        id: newId,
        id_usuario: user_id,
        fecha: new Date().toISOString().split("T")[0],
        total: Number(total.toFixed(2)),
        estado: "pendiente de envio",
        productos: cart
    };

    const response = fetch(API_URL_PEDIDOS, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(newOrder)
    });

    if(!response.ok){
        throw new Error("The order could not be registered");
    }

    const createdProduct = await response.json();
    
    // return createdProduct;
    console.log(createdProduct);
}


//DELETE PRODUCTS 
for(let i=0; i < deleteButtons.length; i++){

    deleteButtons[i].addEventListener("click", function(event){

        console.log("delete button");

        event.preventDefault();

        const id = Number(event.currentTarget.nextElementSibling.textContent);

        console.log(id);

        //remove product from localStorage
        //new array "cart" without this element
        //cart = cart.filter((product) => product.id !== Number(id));

        //find the product
        let product = cart.find((p) => p.id === id);

        //check the quantity to delete
        if(product.quantity > 1){
            //subtract 1 from the quantity
            product.quantity = product.quantity - 1;

            location.reload();
        }else{
            //if quantity = 1, it is removed from the cart
            cart = cart.filter((product) => product.id !== id);

            //remove this card
            event.currentTarget.parentElement.remove();
        }

        //replace de array in localStorage
        localStorage.setItem("cart", JSON.stringify(cart));

        //recalculated price
        priceCalculator();

        emptyCart();

        cartView();
    
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

//HIDE ALERT
alertBox.addEventListener("click", function(){

    alertBox.style.display = "none";
});


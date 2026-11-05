//se lee el localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

console.log(cart);

//variables html
const cartBox = document.getElementById("cart-items");
const deleteButtons = document.getElementsByClassName("delete-button");
const standardRadio = document.getElementById("standard-radio");
const expressRadio = document.getElementById("express-radio");
const totalPrice = document.getElementById("summary-total");
const buyButton = document.getElementsByClassName("buy-manga-button")[0];

//variables
let standardShipping = true;
let expressShipping = false;
let standarPrice = 3.95;
let expressPrice = 6.95;
let total = 0;


console.log(standardRadio.checked);

//FUNCTIONS
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
        <button class="delete-button">DELETE</button>
        <p style="display: none;">${product.id}</p>
    `;

    cartBox.appendChild(productCard);
});

//PRICE CALCULATOR
function priceCalculator(){

    cart.forEach((product) => {

        total = total + product.price;
        
    });

    if(standardShipping){
        total = total + standarPrice;
    }else{
        total = total + expressPrice;
    }

    console.log(total);

}

//LISTENERS

buyButton.addEventListener("click", function(){
    console.log("has pulsado en comprar");
});

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
    
    });
}

//RADIO BUTTONS
standardRadio.addEventListener("change", function(){
    // console.log("standard");
    // console.log("estandard:",standardRadio.checked);
    // console.log("express:",expressRadio.checked);
    standardShipping = true;
    expressShipping = false;
});

expressRadio.addEventListener("change", function(){
    // console.log("Express");
    // console.log("estandard:",standardRadio.checked);
    // console.log("express:",expressRadio.checked);
    expressShipping = true;
    standardShipping = false;
});




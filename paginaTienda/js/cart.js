//se lee el localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

console.log(cart);

//variables html
const cartBox = document.getElementById("cart-items");
const deleteButtons = document.getElementsByClassName("delete-button");


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

//LISTENERS

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
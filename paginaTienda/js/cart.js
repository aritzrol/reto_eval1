//se lee el localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

console.log(cart);

//variables html
const cartBox = document.getElementById("cart-items");



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
        <button>DELETE</button>
    `;

    cartBox.appendChild(productCard);
});


//LISTENERS

//When typing on the search bar, all the volumes are cleared and replaced with those whose title contains the searched value
document.querySelector(`.content`).querySelector(`input`).addEventListener(`keyup`, (e) => {
    document.querySelector(`.products`).innerHTML = "";
    searchVolumes(e.target);
});

//When clicking on any of the filters, they are applied
document.querySelectorAll(`input[type="checkbox"]`).forEach(c => {
    c.addEventListener(`change`, (e) => {
        filterVolumes(e.target);
    });
})

//When changing the order selector, it reorders the volumes according to the option selected
//It calls to sortVolumes with the necessary value (id for chronological order, price for price order)
//If necessary, it reverses the array
document.querySelector(`select`).addEventListener(`change`, (e) => {
    document.querySelector(`.products`).innerHTML = "";
    const option = e.target.value;

    if (option == `new`) {
        sortVolumes(`id`);
        volumes.reverse();

        volumes.forEach(v => {
            displayVolume(v);
        });
    }
    else if (option == `old`) {
        sortVolumes(`id`);
        
        volumes.forEach(v => {
            displayVolume(v);
        });
    }
    else if (option == `cheap`) {
        sortVolumes(`price`);

        volumes.forEach(v => {
            displayVolume(v);
        });
    }
    else if (option == `expensive`) {
        sortVolumes(`price`);
        volumes.reverse();

        volumes.forEach(v => {
            displayVolume(v);
        });
    }
});

//URLs to the series and volumes in the json server
const SERIES_URL = `http://localhost:3000/series`;
const VOLUMES_URL = `http://localhost:3000/volumes`;

//Navbar icons
const cartIcon = document.getElementById("cart-icon");
const alertBox = document.getElementById("alert");

let series = [];
let volumes = [];
let appliedFilters = [];
let serieSeleccionada;
let volumenSeleccionado;

getSeries();
getVolumes();

//Makes a call to the json server and fetches all the series, saving it in a predeclared array
//If something fails, it shows the corresponding error
async function getSeries() {
    try {
        const answer = await fetch(SERIES_URL);

        if (!answer.ok) {
            throw new Error(`Error: ${answer.status}`);
        }

        series = await answer.json();
    }
    catch (error) {
        console.error("Error: " + error.message);
    }
}

//Makes a call to the json server and fetches all the volumes, saving it in a predeclared array
//With each volume, it calls to displayVolume to display the card
//If something fails, it shows the corresponding error
async function getVolumes() {
    try {
        const answer = await fetch(VOLUMES_URL);

        if (!answer.ok) {
            throw new Error(`Error: ${answer.status}`);
        }

        volumes = await answer.json();
        sortVolumes(`id`);

        volumes.reverse();

        volumes.forEach(v => {
            displayVolume(v);
        });
    }
    catch (error) {
        console.error("Error: " + error.message);
    }
}

//It creates a new card with the information of the volume and its corresponding series (cover art, title, number, author, ISBN, price)
//It also adds a button to the card
//The cards are displayed in the products section
//When clicked, the card calls to showProductInfo in order to show the series information
function displayVolume(v) {
    let s;

    const card = document.createElement(`section`);
    series.forEach(se => {
        if (se.id == v.id_series) {
            s = se;
        }
    });

    card.innerHTML = `
    <img src="${v.cover}" alt="${s.title} volume ${v.number}"/>
    <h4>${s.title}</h4>
    <h4>Volume ${v.number}</h4>
    <p>${s.author}</p>
    <p>${v.isbn}</p>
    <hr>
    <section>
    <h4>€${v.price.toFixed(2)}</h4>
    </section>
    `;

    card.className = `card`;
    card.id = `card-${volumes.indexOf(v)}`;

    document.querySelector(`.products`).appendChild(card);

    const btn = document.createElement(`button`);
    btn.type = `button`;
    btn.textContent = `Add to cart`;
    btn.classList.add("add-to-cart-button");

    //button add to cart event
    btn.addEventListener(`click`, (event) => {
        addToCart(event, s, v);
    });

    card.querySelector(`section`).appendChild(btn);

    card.addEventListener(`click`, function () {
        showProductInfo(s, v);
    });
}

// Shows the product card
function showProductInfo(serie, volumen) {
    serieSeleccionada = serie;
    volumenSeleccionado = volumen;
    const ficha = document.querySelector(".series-info");
    const fondo = document.querySelector(".home-modal-backdrop");
    ficha.querySelector("img").src = volumen.cover;
    ficha.querySelector("img").alt = serie.title;
    ficha.querySelector("h2").textContent = serie.title + " #" + volumen.number;
    ficha.querySelector(".product-info-author").textContent = serie.author;
    ficha.querySelector(".product-info-publisher").textContent = serie.publisher;
    ficha.querySelector(".product-info-price").textContent = Number(volumen.price).toFixed(2) + " €";
    ficha.querySelector("span").innerHTML = serie.synopsis;
    ficha.classList.remove(`hidden`);
    fondo.classList.remove(`hidden`);
}

// Closes the card on the X
document.querySelector(".series-info").querySelector("button").addEventListener("click", function () {
    document.querySelector(".series-info").classList.add(`hidden`);
    document.querySelector(".home-modal-backdrop").classList.add(`hidden`);
});

//Add to cart from the product card (same as home)
document.querySelector(".product-info-cart").addEventListener("click", agregarAlCarro);
function agregarAlCarro() {
    const mangaName = serieSeleccionada.title;
    const mangaNumber = volumenSeleccionado.number;
    const mangaPrice = volumenSeleccionado.price;
    const mangaCover = volumenSeleccionado.cover;

    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    let repetido = cart.find((product) => product.name === mangaName && product.number === mangaNumber);

    if (repetido) {

        cart.forEach((product) => {
            if (product.name === mangaName && product.number === mangaNumber) {
                product.quantity = product.quantity + 1;
            }
        });

    } else {

        const product = {
            id: cart.length > 0 ? cart[cart.length - 1].id + 1 : 1,
            name: mangaName,
            number: mangaNumber,
            price: mangaPrice,
            quantity: 1,
            cover: mangaCover
        }

        cart.push(product);

    }

    localStorage.setItem("cart", JSON.stringify(cart));

    const ficha = document.querySelector(".series-info");
    const fondo = document.querySelector(".home-modal-backdrop");
    const boton = ficha.querySelector(".product-info-cart");

    boton.classList.add("clicked");

    setTimeout(function () {
        ficha.classList.add(`hidden`);
        fondo.classList.add(`hidden`);
        boton.classList.remove("clicked");
    }, 250);

    cartView();
}

//It adds the corresponding volume information to localStorage so it can be shown in the cart
function addToCart(event, s, v) {
    //Prevents the card event (call to showProductInfo) from affecting the button
    event.stopPropagation();

    //Information to add to localStorage
    const mangaName = s.title;
    const mangaNumber = v.number;
    const mangaPrice = v.price;
    const mangaCover = v.cover;

    //Gets cart from localStorage. If it doesn't exist, it opens an empty cart
    let cart = JSON.parse(localStorage.getItem("cart")) || [];
    
    //Searches the specific volume in the cart to check if it's been added already
    let existing = cart.find((product) => product.name === mangaName && product.number === mangaNumber);

    //If it exists, the quantity is updated
    if (existing) {

        cart.forEach((product) => {
            if (product.name === mangaName && product.number === mangaNumber) {
                product.quantity = product.quantity + 1;
            }
        });

    //Otherwise, a product is created with the necessary information and it's added to the cart
    } else {
        const product = {
            id: cart.length > 0 ? cart[cart.length - 1].id + 1 : 1,
            name: mangaName,
            number: mangaNumber,
            price: mangaPrice,
            quantity: 1,
            cover: mangaCover
        }
        cart.push(product);

    }

    //The cart array is saved to localStorage
    localStorage.setItem("cart", JSON.stringify(cart)); 
    // alert("The volume has been added to the cart!");

    let text = "The volume has been added to the cart!";
    newAlert(text, "✓");

    cartView();
}

//Checks if any of the series titles contains the value in the search bar. If it does, it calls to displayVolume
function searchVolumes(t) {
    let searchValue = t.value.toLowerCase();

    volumes.forEach(v => {
        let title = series[v.id_series].title.toLowerCase();
        if (title.includes(searchValue)) {
            displayVolume(v);
        }
    });
}

//Sorts volumes based on the selected option
//It compares every single value with all previous values to rearrange them from smallest to biggest
function sortVolumes(option) {
    const n = volumes.length;
    
    //Goes over the array, saving the current value as key. Starts from the second value
    for (i = 1; i < n; ++i) {
        const key = volumes[i];
        let j = i - 1;

        //Enters a loop, comparing the key to all previous values until it finds one that's smaller
        while (j >= 0 && volumes[j][option] > key[option]) {
            volumes[j + 1] = volumes[j];
            j = j - 1;
        }
        volumes[j + 1] = key;
    }
}

//Filters the volumes according to the selected filters
//Calls to toggleFilterDisplay to show the applied filters
function filterVolumes(target) {
    toggleFilterDisplay(target);

    //Saves all checked boxes to an array
    let checkedBoxes = [];
    document.querySelectorAll(`input[type="checkbox"]`).forEach(box => {
        if (box.checked) {
            checkedBoxes.push(box);
        }
    });

    //Empties the product display
    document.querySelector(`.products`).innerHTML = "";

    //If there are no checked boxes, it shows all the volumes
    if (checkedBoxes.length == 0) {
        volumes.forEach(volume => {
            displayVolume(volume);
            return;
        });
    }

    //For each checked box, it makes the necessary comparisons, displaying the volumes only if the validation is fulfilled
    checkedBoxes.forEach(box => {
        if (box.name == "genre") {
            volumes.forEach(volume => {
                series.forEach(serie => {
                    if (serie.id == volume.id_series && serie.genre == box.value) {
                        displayVolume(volume);
                    }
                });
            });
        }

        else if (box.name == "publisher") {
            volumes.forEach(volume => {
                series.forEach(serie => {
                    if (serie.id == volume.id_series && serie.publisher == box.value) {
                        displayVolume(volume);
                    }
                });
            });
        }

        else if (box.name == "price") {
            volumes.forEach(volume => {
                if (box.className == "under10" && volume.price < 10) {
                    displayVolume(volume);
                }
                else if (box.className == "under15" && volume.price > 10 && volume.price < 15) {
                    displayVolume(volume);
                }
                if (box.className == "over15" && volume.price > 15) {
                    displayVolume(volume);
                }
            });
        }
    });

}

//Creates a div with the selected filter's value and saves it to a preexisting array
//If the activated checkbox is checked, the corresponding filter is shown. If not, it is removed
function toggleFilterDisplay(target) {
    const filter = document.createElement(`div`);
    filter.innerHTML = target.value;
    filter.className = target.className;
    appliedFilters.push(filter);

    if (target.checked) {
        document.querySelector(`.appliedFilters`).appendChild(filter);
    }
    else {
        document.querySelector(`.${target.className}`).remove();
    }
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

//When clicking on the x button, it closes the displayed info card, setting the display to none
document.querySelector(`.series-info`).querySelector(`button`).addEventListener(`click`, (e) => {
    e.target.closest(`.series-info`).style.display = `none`;
});

//When typing on the search bar, all the volumes are cleared and replaced with those whose title contains the searched value
document.querySelector(`.content`).querySelector(`input`).addEventListener(`keyup`, (e) => {
    document.querySelector(`.products`).innerHTML = "";
    searchVolumes(e.target);
});

//When clicking on any of the filters, they are applied
document.querySelectorAll(`input[type="checkbox"]`).forEach(c => {
    c.addEventListener(`change`, (e) => {
        if (e.target.checked) {

        }
    });
})

//When changing the order selector, it reorders the volumes according to the option selected
document.querySelector(`select`).addEventListener(`change`, (e) => {
    document.querySelector(`.products`).innerHTML = "";
    const option = e.target.value;

    if (option == `new`) {
        sortById(0, volumes.length - 1);
        
        console.log(volumes);

        volumes.forEach(v => {
            displayVolume(v);
        });
    }
    else if (option == `old`) {
        document.querySelector(`.products`).innerHTML = "";
        sortById(0, volumes.length - 1, option);

        volumes.forEach(v => {
            displayVolume(v);
        });
    }
    else if (option == `cheap`) {

    }
    else if (option == `expensive`) {

    }
});

//URLs to the series and volumes in the json server
const SERIES_URL = `http://localhost:3000/series`;
const VOLUMES_URL = `http://localhost:3000/volumes`;

let series;
let volumes;

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
//When clicked, the card calls to displaySeries in order to show the series information
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
    card.id = `card-${v.id}`;

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

    card.addEventListener(`click`, (e) => {
        displaySeries(e.target);
    })
}

//It overwrites the series-info card with the series information (first volume cover, title, author, synopsis) and displays the card
function displaySeries(t) {
    if (t.className != `card`) {
        t = t.closest(`.card`);
    }

    const card = document.querySelector(`.series-info`);
    const id = t.id.split(`-`)[1];
    const s = series[volumes[id].id_series];
    const cover = volumes.find((volume) => volume.id_series == s.id).cover;

    card.querySelector(`img`).src = cover;
    card.querySelector(`h2`).innerHTML = s.title;
    card.querySelector(`p`).innerHTML = s.author;
    card.querySelector(`span`).innerHTML = s.synopsis;

    card.style.display = `block`;
}

//It adds the corresponding volume information to localStorage so it can be shown in the cart
function addToCart(event, s, v) {
    //Prevents the card event (call to displaySeries) from affecting the button
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
    alert("The volume has been added to the cart!");
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

function swapVolumes(id1, id2) {
    const temp = volumes[id1];
    volumes[id1] = volumes[id2];
    volumes[id2] = temp;
}

function partition (low, high) {
    const part = volumes[high];
    let i = (low);

    for (let j = low; j < high; j++) {
        if (volumes[j].id <= part.id) {
            swapVolumes(i, j);
            i++;
        }
    }

    swapVolumes(i, high);
    
    return i;
}

function sortById(low, high, option) {
    if (volumes[high]!= null && volumes[low]!= null) {
        if (volumes[low].id < volumes[high].id) {
            const part = partition(low, high);
        
            sortById(low, part - 1);
            sortById(part + 1, high);
        }
    };

    console.log(option);
}

getSeries();
getVolumes();

document.querySelector(`.series-info`).querySelector(`button`).addEventListener(`click`, (e) => {
    e.target.closest(`.series-info`).style.display = `none`;
});

document.querySelector(`.content`).querySelector(`input`).addEventListener(`keyup`, (e) => {
    document.querySelector(`.products`).innerHTML = "";
    searchVolumes(e.target);
});

document.querySelectorAll(`input[type="checkbox"]`).forEach(c => {
    c.addEventListener(`change`, (e) => {
        if (e.target.checked) {
            
        }
    });
})

const SERIES_URL = `http://localhost:3000/series`;
const VOLUMES_URL = `http://localhost:3000/volumes`;

let series;
let volumes;

getSeries();
getVolumes();

async function getSeries() {
    try {
        const answer = await fetch(SERIES_URL);

        if(!answer.ok) {
            throw new Error(`Error: ${answer.status}`);
        }

        series = await answer.json();
    }
    catch(error) {
        console.error("Error: " + error.message);
    }
}

async function getVolumes() {
    try {
        const answer = await fetch(VOLUMES_URL);

        if(!answer.ok) {
            throw new Error(`Error: ${answer.status}`);
        }

        volumes = await answer.json();
        
        volumes.forEach(v => {
            displayVolume(v);
        });
    }
    catch(error) {
        console.error("Error: " + error.message);
    }
}

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
    <h3>${s.title}</h3>
    <h4>Volume ${v.number}</h4>
    <p>${s.author}</p>
    <p>${s.publisher}</p>
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

        event.stopPropagation(); // esto evita que se abra la tarjeta de los detalles
        //console.log(" botón Add to cart de: ", v.number, s.title);
        
        //LOCALSTORAGE
        const mangaName = s.title;
        const mangaNumber = v.number;
        const mangaPrice = v.price;
        const mangaCover = v.cover;

        //console.log(mangaName, mangaNumber, mangaPrice);

        //lee el array del carrito desde localStorage o lo crea vacio
        let cart = JSON.parse(localStorage.getItem("cart")) || [];

        let repetido = cart.find((product) => product.name === mangaName && product.number === mangaNumber);

        //si ya existe solo aumenta quantity
        if(repetido){

            cart.forEach((product) =>{
                if(product.name === mangaName && product.number === mangaNumber){
                    product.quantity = product.quantity + 1;
                }
            });
            
        }else{

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

        //guardar en localStorage
        localStorage.setItem("cart", JSON.stringify(cart));

    });

    card.querySelector(`section`).appendChild(btn);

    card.addEventListener(`click`, (e) => {
        displaySeries(e.target);
    })
}

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

function searchVolumes(t) {
    let searchValue = t.value.toLowerCase();

    let search = [];

    volumes.forEach(v => {
        let title = series[v.id_series].title.toLowerCase();
        console.log(v);
        if (title.includes(searchValue)) {
            search.push(v);
            displayVolume(v);
        }
    });
}

const addToCart = document.querySelectorAll("add-to-cart-button");

addToCart.forEach((button) => {
    addToCart.addEventListener("click", function(){
    
        console.log("has pulsado el boton ADD TO CART");    
    })
})

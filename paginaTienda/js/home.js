const SERIES_URL = "store.json";
const cartIcon = document.getElementById("cart-icon");
let series = [];
let volumes = [];
let serieSeleccionada;
let volumenSeleccionado;



// Descarga las series y los volúmenes del archivo JSON.
async function getSeries() {
    try {
        const answer = await fetch(SERIES_URL);
        if (!answer.ok) {
            throw new Error("No se han podido cargar los datos");
        }

        const data = await answer.json();
        series = data.series;
        volumes = data.volumes;

        showNewReleases();
        showBestSellers();
        showFeaturedBooks();
    } catch (error) {
        console.error("Error: " + error.message);
    }
}

// Muestra los dos últimos volúmenes de cada serie.
function showNewReleases() {
    for (let i = 0; i < series.length; i++) {
        let count = 0;
        const serie = series[i];

        for (let j = volumes.length - 1; j >= 0 && count < 2; j--) {
            const volumen = volumes[j];
            if (volumen.id_series == serie.id) {
                displayVolume(serie, volumen, "new-releases", false);
                count++;
            }
        }
    }
}

// Muestra los ocho volúmenes con el precio más alto.
function showBestSellers() {
    const sortedVolumes = [];

    // Copia los volúmenes para poder ordenarlos sin cambiar la lista original.
    for (let i = 0; i < volumes.length; i++) {
        sortedVolumes.push(volumes[i]);
    }

    // Ordena los volúmenes desde el precio más alto al más bajo.
    for (let i = 0; i < sortedVolumes.length; i++) {
        for (let j = 0; j < sortedVolumes.length - 1; j++) {
            if (Number(sortedVolumes[j].price) < Number(sortedVolumes[j + 1].price)) {
                const temporaryVolume = sortedVolumes[j];
                sortedVolumes[j] = sortedVolumes[j + 1];
                sortedVolumes[j + 1] = temporaryVolume;
            }
        }
    }

    // Busca la serie correspondiente y muestra los primeros ocho volúmenes.
    for (let i = 0; i < 8 && i < sortedVolumes.length; i++) {
        let serieDelVolumen = null;

        for (let j = 0; j < series.length; j++) {
            if (series[j].id == sortedVolumes[i].id_series) {
                serieDelVolumen = series[j];
            }
        }

        if (serieDelVolumen !== null) {
            displayVolume(serieDelVolumen, sortedVolumes[i], "best-sellers", false);
        }
    }
}

// Muestra hasta seis portadas destacadas.
function showFeaturedBooks() {
    let count = 0;

    for (let i = 0; i < volumes.length && count < 6; i++) {
        let serieDelVolumen = null;

        for (let j = 0; j < series.length; j++) {
            if (series[j].id == volumes[i].id_series) {
                serieDelVolumen = series[j];
            }
        }

        if (serieDelVolumen !== null) {
            displayVolume(serieDelVolumen, volumes[i], "featured-books", true);
            count++;
        }
    }
}

// Crea una tarjeta con los datos del título y del volumen.
function displayVolume(serie, volumen, sectionId, compact) {
    const card = document.createElement("article");

    if (compact) {
        card.className = "carousel-item";
        card.innerHTML = `
            <img src="${volumen.cover}" alt="${serie.title} volumen ${volumen.number}">
            <div class="carousel-caption d-none d-md-block">
                <h5>${serie.title}</h5>
                <p>Volumen ${volumen.number}</p>
            </div>
        `;

        if (document.getElementById(sectionId).children.length === 0) {
            card.classList.add("active");
        }
    } else {
        card.className = "product";
        card.innerHTML = `
            <img src="${volumen.cover}" alt="${serie.title} volumen ${volumen.number}">
            <small>${serie.publisher}</small>
            <h3>${serie.title} #${volumen.number}</h3>
            <small>${serie.author}</small>
            <p class="price">${volumen.price} €</p>
        `;
    }

    document.getElementById(sectionId).appendChild(card);

    card.addEventListener("click", function () {
        showProductInfo(serie, volumen);
    });
}

// Muestra la información en la ficha igual que en el catálogo.
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

//Añadir al carrito
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

// Cierra la ficha al pulsar la X.
document.querySelector(".series-info").querySelector("button").addEventListener("click", function () {
    document.querySelector(".series-info").classList.add(`hidden`);
    document.querySelector(".home-modal-backdrop").classList.add(`hidden`);
});

getSeries();


//CART LIGHT
function cartView(){
    
    // sin icono en esta página, no hay nada que hacer
    if(cartIcon === null) return;

    //Check localStorage if any products exists
    let cartStorage = JSON.parse(localStorage.getItem("cart")) || [];

    if(cartStorage.length > 0){
        cartIcon.classList.add("cart-icon");      
    }else{
        cartIcon.classList.remove("cart-icon");  
    }
    
}

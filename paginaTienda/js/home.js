const SERIES_URL = "store.json";
let series = [];
let volumes = [];

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
    const usedVolumes = [];

    for (let i = 0; i < 8; i++) {
        let mostExpensive = null;

        for (let j = 0; j < volumes.length; j++) {
            const volumen = volumes[j];
            let alreadyUsed = false;

            for (let k = 0; k < usedVolumes.length; k++) {
                if (usedVolumes[k] === volumen.id) {
                    alreadyUsed = true;
                }
            }

            if (!alreadyUsed && (mostExpensive === null || volumen.price > mostExpensive.price)) {
                mostExpensive = volumen;
            }
        }

        if (mostExpensive !== null) {
            let serieDelVolumen = null;
            for (let j = 0; j < series.length; j++) {
                if (series[j].id === mostExpensive.id_series) {
                    serieDelVolumen = series[j];
                }
            }

            if (serieDelVolumen !== null) {
                displayVolume(serieDelVolumen, mostExpensive, "best-sellers", false);
                usedVolumes.push(mostExpensive.id);
            }
        }
    }
}

// Muestra hasta seis portadas destacadas.
function showFeaturedBooks() {
    let count = 0;

    for (let i = 0; i < volumes.length && count < 6; i++) {
        let serieDelVolumen = null;

        for (let j = 0; j < series.length; j++) {
            if (series[j].id === volumes[i].id_series) {
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
        card.className = "featured-book";
        card.innerHTML = `<img src="${volumen.cover}" alt="${serie.title}">`;
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
}

getSeries();
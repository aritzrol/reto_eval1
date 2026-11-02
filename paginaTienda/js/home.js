const SERIES_URL = "store.json";
let series = [];

// Descarga las series del JSON y muestra sus primeros volúmenes.
async function getSeries() {
    try {
        const answer = await fetch(SERIES_URL);
        if (!answer.ok) throw new Error(`Error: ${answer.status}`);

        const data = await answer.json();
        series = data.series;

        let featuredCount = 0;

        series.forEach(s => {
            if (s.volumes.length > 0) {
                displayVolume(s, s.volumes[0], "new-releases");
                displayVolume(s, s.volumes[0], "best-sellers");
                if (featuredCount < 3) {
                    displayVolume(s, s.volumes[0], "featured-books", true);
                    featuredCount++;
                }
            }
        });
    } catch (error) {
        console.error("Error: " + error.message);
    }
}

// Crea una tarjeta para el título y volumen recibidos.
function displayVolume(s, v, sectionId, compact = false) {
    const card = document.createElement("article");
    card.className = compact ? "featured-book" : "product";

    card.innerHTML = `
        <img src="${v.cover}" alt="${s.title} volumen ${v.number}">
        ${compact ? "" : `<small>${s.publisher}</small>
        <h3>${s.title} #${v.number}</h3>
        <small>${s.author}</small>
        <p class="price">${v.price} €</p>`}
    `;

    document.getElementById(sectionId).appendChild(card);
}

getSeries();
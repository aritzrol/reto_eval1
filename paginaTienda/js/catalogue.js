const SERIES_URL = `http://localhost:3000/series`;
const VOLUMES_URL = `http://localhost:3000/volumes`;

let series;
let volumes;

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

    console.log(v);
    const card = document.createElement(`section`);
    series.forEach(se => {
        if (se.id == v.id_series) {
            s = se;
        }
    });

    card.innerHTML = `
    <img src="${v.cover}" alt="${s.title} volume ${v.number}"/>
    <section>
    <h4>${s.title} ${v.number}
    <p>${s.author}</p>
    <p>€${v.price}</p>
    <p>${v.isbn}</p>
    </section>
    `;

    document.querySelector(`.products`).appendChild(card);
}

getSeries();
getVolumes();
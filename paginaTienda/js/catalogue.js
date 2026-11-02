const SERIES_URL = `http://localhost:3000/series`;

async function getSeries() {
    try {
        const answer = await fetch(SERIES_URL);

        if(!answer.ok) {
            throw new Error(`Error: ${answer.status}`);
        }

        series = await answer.json();

        series.forEach(s => {
            s.volumes.forEach(v => {
                displayVolume(v);
            });
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
    <h4>${s.title} ${v.number}</h4>
    <p>${s.author}</p>
    <p>€${v.price}</p>
    `;

    document.querySelector(`.products`).appendChild(card);
}

getSeries();
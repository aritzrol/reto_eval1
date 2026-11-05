// Aplica el tema guardado y permite cambiarlo desde el icono del navbar.
const darkModeIcon = document.querySelector('nav img[src*="darkMode_icon.png"]');

if (localStorage.getItem("darkMode") === "true") {
    document.body.classList.add("dark-mode");
}

if (darkModeIcon !== null) {
    const darkModeButton = darkModeIcon.closest("a");

    darkModeButton.addEventListener("click", function (event) {
        event.preventDefault();

        document.body.classList.toggle("dark-mode");
        localStorage.setItem("darkMode", document.body.classList.contains("dark-mode"));
    });
}
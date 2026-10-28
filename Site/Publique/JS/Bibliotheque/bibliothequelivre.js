// Constante de navigation
const zoneLivre = document.querySelector(".zone-livre");
const pagePrecedente = document.getElementById("pagePrecedente");
const pageSuivante = document.getElementById("pageSuivante");

// Constante de récupération des données des équipements
const donnees = JSON.parse(bouton.dataset.equipement);

// Navigation entre les pages du livre
pageSuivante.addEventListener("click", function () {
    zoneLivre.scrollBy({ left: zoneLivre.clientWidth, behavior: "smooth" });
});

pagePrecedente.addEventListener("click", function () {
    zoneLivre.scrollBy({ left: -zoneLivre.clientWidth, behavior: "smooth" });
});
// Constante de navigation
const zoneLivre = document.querySelector(".zone-livre");
const pagePrecedente = document.getElementById("pagePrecedente");
const pageSuivante = document.getElementById("pageSuivante");

// Navigation entre les pages du livre
function largeurDePage() {
    return zoneLivre.getBoundingClientRect().width + parseFloat(getComputedStyle(zoneLivre).columnGap);
}

function allerALaPage(decalage) {
    const pas = largeurDePage();
    const pageActuelle = Math.round(zoneLivre.scrollLeft / pas);
    zoneLivre.scrollTo({ left: (pageActuelle + decalage) * pas, behavior: "smooth" });
}

pageSuivante.addEventListener("click", function () {
    allerALaPage(1);
});

pagePrecedente.addEventListener("click", function () {
    allerALaPage(-1);
});
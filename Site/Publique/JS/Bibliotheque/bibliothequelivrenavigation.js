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

function afficherFlecheNavigation() {
    if (zoneLivre.scrollWidth > zoneLivre.clientWidth + 1) {
        pagePrecedente.hidden = false;
        pageSuivante.hidden = false;
    } else {
        pagePrecedente.hidden = true;
        pageSuivante.hidden = true;
    }
}

pageSuivante.addEventListener("click", function () {
    allerALaPage(1);
});

pagePrecedente.addEventListener("click", function () {
    allerALaPage(-1);
});

window.addEventListener("resize", afficherFlecheNavigation);
afficherFlecheNavigation();
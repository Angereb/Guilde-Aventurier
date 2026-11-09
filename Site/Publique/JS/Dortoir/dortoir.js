// Constante de navigation
const litsAventuriers = document.querySelector(".lits-aventuriers");
const dortoirPrecedent = document.getElementById("dortoirPrecedent");
const dortoirSuivant = document.getElementById("dortoirSuivant");

// Navigation entre les les dortoirs
function largeurDePage() {
    return litsAventuriers.getBoundingClientRect().width;
}

function allerALaPage(decalage) {
    const pas = largeurDePage();
    const dortoirActuel = Math.round(litsAventuriers.scrollLeft / pas);
    litsAventuriers.scrollTo({ left: (dortoirActuel + decalage) * pas, behavior: "smooth" });
}

if (litsAventuriers !== null) {
    dortoirSuivant.addEventListener("click", function () {
        allerALaPage(1);
    });
    dortoirPrecedent.addEventListener("click", function () {
        allerALaPage(-1);
    });
}
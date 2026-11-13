const etageresCompetences = document.querySelector(".etageres-competences");
const bibliothequePrecedente = document.getElementById("bibliothequePrecedente");
const bibliothequeSuivante = document.getElementById("bibliothequeSuivante");

function allerALaRangee(decalage) {
    const vertical = window.matchMedia("(min-width: 768px)").matches;
    const taille = vertical ? etageresCompetences.getBoundingClientRect().height : etageresCompetences.getBoundingClientRect().width;
    const position = vertical ? etageresCompetences.scrollTop : etageresCompetences.scrollLeft;
    const destination = (Math.round(position / taille) + decalage) * taille;
    if (vertical) {
        etageresCompetences.scrollTo({ top: destination, behavior: "smooth" });
    } else {
        etageresCompetences.scrollTo({ left: destination, behavior: "smooth" });
    }
}

function afficherFlecheNavigation() {
    const vertical = window.matchMedia("(min-width: 768px)").matches;
    let contenuDepasse;
    if (vertical) {
        contenuDepasse = etageresCompetences.scrollHeight > etageresCompetences.clientHeight + 1;
    } else {
        contenuDepasse = etageresCompetences.scrollWidth > etageresCompetences.clientWidth + 1;
    }
    if (contenuDepasse) {
        bibliothequePrecedente.hidden = false;
        bibliothequeSuivante.hidden = false;
    } else {
        bibliothequePrecedente.hidden = true;
        bibliothequeSuivante.hidden = true;
    }
}

bibliothequeSuivante.addEventListener("click", function () {
    allerALaRangee(1);
});

bibliothequePrecedente.addEventListener("click", function () {
    allerALaRangee(-1);
});

window.addEventListener("resize", afficherFlecheNavigation);
afficherFlecheNavigation();
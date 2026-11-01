const etageresCompetences = document.querySelector(".etageres-competences");
const rangeePrecedente = document.getElementById("rangeePrecedente");
const rangeeSuivante = document.getElementById("rangeeSuivante");

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

rangeeSuivante.addEventListener("click", function () {
    allerALaRangee(1);
});

rangeePrecedente.addEventListener("click", function () {
    allerALaRangee(-1);
});
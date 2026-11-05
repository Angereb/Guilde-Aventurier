// Éléments pour l'ouverture du magasin
const ouvertureModaleMagasin = document.getElementById("ouvertureModaleMagasin");
let inventaireFiche = [];

// Aperçu de l'icône choisie par le joueur
const iconeAventurier = document.getElementById("iconeAventurier");
const apercuIconeAventurier = document.getElementById("apercuIconeAventurier");

iconeAventurier.addEventListener("change", function () {
    const fichier = iconeAventurier.files[0];
    if (fichier !== undefined) {
        apercuIconeAventurier.src = URL.createObjectURL(fichier);
        apercuIconeAventurier.alt = "Aperçu de l'icône choisie";
        apercuIconeAventurier.hidden = false;
    }
});

function recupererPanier(panierRecu) {
    inventaireFiche = panierRecu;
    console.log(panierRecu);
}

ouvertureModaleMagasin.addEventListener("click", function () {
    ouvrirMagasin(inventaireFiche, recupererPanier);
});
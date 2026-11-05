// Constante du formulaire
const formulaireAventurier = document.getElementById("formulaireAventurier");

// Constantes des lignes des caractéristiques et des maîtrises
const toutesLignesValeurs = document.querySelectorAll(".ligne-valeur");

// Aperçu de l'icône choisie par le joueur
const iconeAventurier = document.getElementById("iconeAventurier");
const apercuIconeAventurier = document.getElementById("apercuIconeAventurier");

// Éléments pour l'ouverture du magasin
const ouvertureModaleMagasin = document.getElementById("ouvertureModaleMagasin");
let inventaireFiche = [];

// Constante pour l'affichage des équipements
const toutesZonesCategories = document.querySelectorAll("[data-categorie]");
const modeleLigneEquipement = document.getElementById("modeleLigneEquipement");

// Constante pour l'affichage des compétences
const zoneCompetence = document.getElementById("competence");
const modeleZoneCompetence = document.getElementById("modeleZoneCompetence");

// Détection du changement d'îcone pour remplacement du bouton par l'îcone choisi
iconeAventurier.addEventListener("change", function () {
    const fichier = iconeAventurier.files[0];
    if (fichier !== undefined) {
        apercuIconeAventurier.src = URL.createObjectURL(fichier);
        apercuIconeAventurier.alt = "Aperçu de l'icône choisie";
        apercuIconeAventurier.hidden = false;
    }
});

// Fonction pour afficher les compétences en fonctions des prèrequis
function afficherCompetence() {
    zoneCompetence.innerHTML = "";
    for (const competence of DONNEES_FICHE["competences"]) {
        let competenceVisible = true;
        for (const requis of competence.requis) {
            const champIdcible = document.getElementById(requis.cible)
            if (Number(champIdcible.value) < requis.valeur) {
                competenceVisible = false;
            } 
        }
        if (competenceVisible) {
            const ficheCompetence = modeleZoneCompetence.content.cloneNode(true);
            ficheCompetence.querySelector(".nom-competence").textContent = competence.competence.nom;
            ficheCompetence.querySelector(".recueil-competence").textContent = competence.recueil;
            ficheCompetence.querySelector(".descriptions-competence").textContent = competence.competence.descriptions;
            if (competence.competence.zoneEffetId !== null) {
                ficheCompetence.querySelector(".icone-zone-effet-competence").src = DONNEES_FICHE.iconesZonesEffets[competence.competence.zoneEffetId];
                ficheCompetence.querySelector(".icone-zone-effet-competence").alt = DONNEES_FICHE.nomsZonesEffets[competence.competence.zoneEffetId];
            } else {
                ficheCompetence.querySelector(".icone-zone-effet-competence").hidden = true;
            }
            ficheCompetence.querySelector(".cout-pe-competence").textContent = "Coût : " + competence.competence.coutPE + " PE";
            zoneCompetence.appendChild(ficheCompetence);
        }
    }
}

// Action de modification des valeurs de caractéristiques et de maîtrises
for (const lignes of toutesLignesValeurs) {
    const champValeur = lignes.querySelector("input");
    const boutons = lignes.querySelectorAll("button");
    for (const bouton of boutons) {
        bouton.addEventListener("click", function() {
            const pasBouton = Number(bouton.dataset.pas);
            const valeurActuel = Number(champValeur.value);
            let nouvelleValeur = valeurActuel + pasBouton;
            nouvelleValeur = Math.max(Number(champValeur.min), nouvelleValeur);
            nouvelleValeur = Math.min(Number(champValeur.max), nouvelleValeur);
            champValeur.value = nouvelleValeur;
            afficherCompetence();
        })
    }
    champValeur.addEventListener("change", function() {
        let valeur = Number(champValeur.value);
        if (valeur < Number(champValeur.min)) {
            valeur = Number(champValeur.min);
        }
        if (valeur > Number(champValeur.max)) {
            valeur = Number(champValeur.max);
        }
        champValeur.value = Math.floor(valeur);
        afficherCompetence();
    })
}

// Blocage de la touche entrée pour qu'elle ne valide pas le formulaire
formulaireAventurier.addEventListener("keydown", (evenement) => {
    if (evenement.key === 'Enter' && evenement.target.tagName === "INPUT") {
        evenement.preventDefault();
    }
});

// Fonction permettant d'affiché l'inventaire
function afficherEquipement(inventaire) {
    for (const zoneCategorie of toutesZonesCategories) {
        zoneCategorie.innerHTML = "";
    }
    for (const equipementAchete of inventaire) {
        const ficheInventaire = modeleLigneEquipement.content.cloneNode(true);
        ficheInventaire.querySelector(".equipement-nom").textContent = equipementAchete.nom;
        ficheInventaire.querySelector(".equipement-quantite").textContent = equipementAchete.quantite;
        ficheInventaire.querySelector(".equipement-etat").textContent = equipementAchete.etat;
        const zoneCategorie = document.querySelector('[data-categorie="' + equipementAchete.categorie + '"]');
        zoneCategorie.appendChild(ficheInventaire);
    }
}

// Fonction permettant de récupérer les données du magasin
function recupererPanier(panierRecu) {
    inventaireFiche = panierRecu;
    afficherEquipement(inventaireFiche);
}

// Action d'ouverture de l'inventaire avec mise en paramètre de la fonction de récupération
ouvertureModaleMagasin.addEventListener("click", function () {
    ouvrirMagasin(inventaireFiche, recupererPanier);
});

afficherCompetence();
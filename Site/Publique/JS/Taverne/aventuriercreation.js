// Constante du formulaire
const formulaireAventurier = document.getElementById("formulaireAventurier");

// Constantes des champs à vérifier
const nomAventurier = document.getElementById("nomAventurier");

// Constantes des lignes des caractéristiques et des maîtrises
const toutesLignesValeurs = document.querySelectorAll(".ligne-valeur");

// Constantes des lignes des caractéristiques secondaires
const pvActuelAventurier = document.getElementById("pvActuelAventurier");
const pvMaxAventurier = document.getElementById("pvMaxAventurier");
const peActuelAventurier = document.getElementById("peActuelAventurier");
const peMaxAventurier = document.getElementById("peMaxAventurier");
const attaqueAventurier = document.getElementById("attaqueAventurier");
const defenseAventurier = document.getElementById("defenseAventurier");
const initiativeAventurier = document.getElementById("initiativeAventurier");
const mouvementAventurier = document.getElementById("mouvementAventurier");

// Aperçu de l'icône choisie par le joueur
const iconeAventurier = document.getElementById("iconeAventurier");
const apercuIconeAventurier = document.getElementById("apercuIconeAventurier");

// Éléments pour l'ouverture du magasin
const ouvertureModaleMagasin = document.getElementById("ouvertureModaleMagasin");
let inventaireFiche = [];

// Constante pour l'affichage des équipements
const toutesZonesCategories = document.querySelectorAll("[data-categorie]");
const modeleLigneEquipement = document.getElementById("modeleLigneEquipement");
const inventaireAventurier = document.getElementById("inventaireAventurier");

// Constante pour l'affichage des compétences
const zoneCompetence = document.getElementById("competence");
const modeleZoneCompetence = document.getElementById("modeleZoneCompetence");

// Constante du total du coût en PC
const pcAventurier = document.getElementById("pcAventurier");

// Fonction de vérification de déblocage d'une compétence
function competenceDebloquee(competence) {
    for (const requis of competence.requis) {
        const champIdcible = document.getElementById(requis.cible)
        if (Number(champIdcible.value) < requis.valeur) {
            return false;
        } 
    }
    return true;
}

// Fonction pour afficher les compétences en fonctions des prèrequis
function afficherCompetence() {
    zoneCompetence.innerHTML = "";
    for (const competence of DONNEES_FICHE["competences"]) {
        if (competenceDebloquee(competence)) {
            const ficheCompetence = modeleZoneCompetence.content.cloneNode(true);
            ficheCompetence.querySelector(".nom-competence").textContent = competence.competence.nom;
            ficheCompetence.querySelector(".recueil-competence").textContent = competence.recueil;
            ficheCompetence.querySelector(".descriptions-competence").textContent = competence.competence.descriptions;
            for (const modificateur of competence.modificateurs) {
                const ligneModificateur = document.createElement("li");
                ligneModificateur.textContent = modificateur.nom + " : " + modificateur.valeur;
                ficheCompetence.querySelector(".modificateur-principaux-competence").appendChild(ligneModificateur);
            }
            if (competence.competence.modifAttaque !== null) {
                ficheCompetence.querySelector(".modificateur-attaque-competence").textContent = "Attaque : " + competence.competence.modifAttaque;
            } else {
                ficheCompetence.querySelector(".modificateur-attaque-competence").hidden = true;
            }
            if (competence.competence.modifDefense !== null) {
                ficheCompetence.querySelector(".modificateur-defense-competence").textContent = "Défense : " + competence.competence.modifDefense;
            } else {
                ficheCompetence.querySelector(".modificateur-defense-competence").hidden = true;
            }
            if (competence.competence.modifPV !== null) {
                ficheCompetence.querySelector(".modificateur-pv-competence").textContent = "PV : " + competence.competence.modifPV;
            } else {
                ficheCompetence.querySelector(".modificateur-pv-competence").hidden = true;
            }
            if (competence.competence.modifPE !== null) {
                ficheCompetence.querySelector(".modificateur-pe-competence").textContent = "PE : " + competence.competence.modifPE;
            } else {
                ficheCompetence.querySelector(".modificateur-pe-competence").hidden = true;
            }
            if (competence.competence.modifInitiative !== null) {
                ficheCompetence.querySelector(".modificateur-initiative-competence").textContent = "Initiative : " + competence.competence.modifInitiative;
            } else {
                ficheCompetence.querySelector(".modificateur-initiative-competence").hidden = true;
            }
            if (competence.competence.modifMouvement !== null) {
                ficheCompetence.querySelector(".modificateur-mouvement-competence").textContent = "Mouvement : " + competence.competence.modifMouvement;
            } else {
                ficheCompetence.querySelector(".modificateur-mouvement-competence").hidden = true;
            }
            if (competence.competence.zoneEffetId !== null) {
                ficheCompetence.querySelector(".icone-zone-effet-competence").src = DONNEES_FICHE.iconesZonesEffets[competence.competence.zoneEffetId];
                ficheCompetence.querySelector(".icone-zone-effet-competence").alt = DONNEES_FICHE.nomsZonesEffets[competence.competence.zoneEffetId];
                ficheCompetence.querySelector(".cout-pe-competence").textContent = "Coût : " + competence.competence.coutPE + " PE";
            } else {
                ficheCompetence.querySelector(".icone-zone-effet-competence").hidden = true;
                ficheCompetence.querySelector(".cout-pe-competence").hidden = true;
            }
            zoneCompetence.appendChild(ficheCompetence);
        }
    }
}

// Fonction de calcul de coût en PC d'une valeur selon un palier
function calculerCoutValeur(valeur, listePaliers) {
    let total = 0;
    for (let niveau = 1; niveau <= valeur; niveau++) {
        for (const palier of listePaliers) {
            if (niveau <= palier.jusqua) {
                total = total + palier.cout;
                break;
            }
        }
    }
    return total;
}

// Fonction de calcul du tital de Point de Compagnie utilisé pour un aventurier
function calculerCoutPC() {
    let total = 0;
    for (const lignes of toutesLignesValeurs) {
        const champValeur = lignes.querySelector("input");
        let palier;
        if (champValeur.id.startsWith("caracteristique-")) {
            palier = DONNEES_FICHE.regles.caracteristiques.paliers;
        } else {
            palier = DONNEES_FICHE.regles.maitrises.paliers;
        }
        total = total + calculerCoutValeur(Number(champValeur.value), palier);
    }
    for (const equipement of inventaireFiche) {
        total = total + equipement.coutPC * equipement.quantite;
    }
    pcAventurier.textContent = "Total : " + total + " PC";
}

// Fonction de calcul des statistiques secondaires
function calculerStatistiquesSecondaires() {
    let vitaliteId;
    for (const id in DONNEES_FICHE.nomsCaracteristiques) {
        if (DONNEES_FICHE.nomsCaracteristiques[id] === DONNEES_FICHE.regles.secondaires.caracteristiqueVitalite) {
            vitaliteId = id;
        }
    }
    const idChampVitalite = "caracteristique-" + vitaliteId;
    const champVitalite = document.getElementById(idChampVitalite);
    let valeurVitalite = Number(champVitalite.value);
    let pv = DONNEES_FICHE.regles.secondaires.pv.base;
    let pe = DONNEES_FICHE.regles.secondaires.pe.base;
    let attaque = DONNEES_FICHE.regles.secondaires.attaque.base;
    let defense = DONNEES_FICHE.regles.secondaires.defense.base;
    let initiative = DONNEES_FICHE.regles.secondaires.initiative.base;
    let mouvement = DONNEES_FICHE.regles.secondaires.mouvement.base;
    for (const competence of DONNEES_FICHE["competences"]) {
        if (competence.competence.zoneEffetId === null && competenceDebloquee(competence)) {
            for (const modificateur of competence.modificateurs) {
                if (modificateur.cible === idChampVitalite) {
                    valeurVitalite = valeurVitalite + Number(modificateur.valeur);
                }
            }
            if (competence.competence.modifPV !== null) {
                pv = pv + competence.competence.modifPV;
            }
            if (competence.competence.modifPE !== null) {
                pe = pe + competence.competence.modifPE;
            }
            if (competence.competence.modifAttaque !== null) {
                attaque = attaque + competence.competence.modifAttaque;
            }
            if (competence.competence.modifDefense !== null) {
                defense = defense + competence.competence.modifDefense;
            }
            if (competence.competence.modifInitiative !== null) {
                initiative = initiative + competence.competence.modifInitiative;
            }
            if (competence.competence.modifMouvement !== null) {
                mouvement = mouvement + competence.competence.modifMouvement;
            }
        }
    }
    pv = pv + DONNEES_FICHE.regles.secondaires.pv.parNiveau * valeurVitalite;
    pe = pe + Math.floor(valeurVitalite / DONNEES_FICHE.regles.secondaires.pe.niveauxParPoint);
    pvActuelAventurier.textContent = pv;
    pvMaxAventurier.textContent = pv;
    peActuelAventurier.textContent = pe;
    peMaxAventurier.textContent = pe;
    attaqueAventurier.textContent = attaque;
    defenseAventurier.textContent = defense;
    initiativeAventurier.textContent = initiative;
    mouvementAventurier.textContent = mouvement;
}

function mettreAjourFiche() {
    afficherCompetence();
    calculerStatistiquesSecondaires();
    calculerCoutPC();
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
            mettreAjourFiche();
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
        mettreAjourFiche();
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
    inventaireAventurier.value = JSON.stringify(panierRecu);
    afficherEquipement(inventaireFiche);
    mettreAjourFiche();
}

// Action d'ouverture de l'inventaire avec mise en paramètre de la fonction de récupération
ouvertureModaleMagasin.addEventListener("click", function () {
    ouvrirMagasin(inventaireFiche, recupererPanier);
});

// Validation des champs du formulaire
function verifierNomAventurier() {
    const nomAventurierTrim = nomAventurier.value.trim();
    if (nomAventurierTrim === "") {
        afficherErreur(nomAventurier, "L'aventurier doit avoir un nom.");
        return false;
    }
    if (nomAventurierTrim.length > 64) {
        afficherErreur(nomAventurier, "Le nom de l'aventurier ne peut excéder 64 caractères.");
        return false;
    }
    effacerErreur(nomAventurier);
    return true;
}

function verifierIcone() {
    const fichier = iconeAventurier.files[0];
    if (fichier === undefined) {
        effacerErreur(iconeAventurier);
        return true;
    }
    if (!["image/png", "image/jpeg", "image/webp"].includes(fichier.type)) {
        afficherErreur(iconeAventurier, "L'icône doit être une image PNG, JPEG ou WebP.");
        return false;
    }
    if (fichier.size > 2 * 1024 * 1024) {
        afficherErreur(iconeAventurier, "L'icône ne doit pas dépasser 2 Mo.");
        return false;
    }
    effacerErreur(iconeAventurier);
    return true;
}

function verifierValeurs() {
    let valeursValides = true;
    for (const lignes of toutesLignesValeurs) {
        effacerErreur(lignes.querySelector("input"));
    }
    for (const lignes of toutesLignesValeurs) {
        const champValeur = lignes.querySelector("input");
        const valeurNombre = Number(champValeur.value);
        const nomChamp = lignes.querySelector("label").textContent;
        let regleValeur;
        if (champValeur.id.startsWith("caracteristique-")) {
            regleValeur = DONNEES_FICHE.regles.caracteristiques;
        } else {
            regleValeur = DONNEES_FICHE.regles.maitrises;
        }
        if (champValeur.value === "" || !Number.isInteger(valeurNombre)) {
            afficherErreur(champValeur, nomChamp + "la valeur doit être un nombre entier.");
            valeursValides = false;
        } else if (valeurNombre < regleValeur.minimum || valeurNombre > regleValeur.maximum) {
            afficherErreur(champValeur, nomChamp + "la valeur doit être entre " + regleValeur.minimum + " et " + regleValeur.maximum + ".");
            valeursValides = false;
        }
    }
    return valeursValides;
}

nomAventurier.addEventListener("blur", verifierNomAventurier);
iconeAventurier.addEventListener("change", function () {
    const fichier = iconeAventurier.files[0];
    if (fichier !== undefined && verifierIcone()) {
        apercuIconeAventurier.src = URL.createObjectURL(fichier);
        apercuIconeAventurier.alt = "Aperçu de l'icône choisie";
        apercuIconeAventurier.hidden = false;
    }
});

formulaireAventurier.addEventListener("submit", function(event) {
    let formulaireAventurierValide = true;
    if (!verifierNomAventurier()) {
        formulaireAventurierValide = false;
    }
    if (!verifierIcone()) {
        formulaireAventurierValide = false;
    }
    if (!verifierValeurs()) {
        formulaireAventurierValide = false;
    }
    if (formulaireAventurierValide === false) {
        event.preventDefault();
    }
})

mettreAjourFiche();
const ouvertureModaleCompetence = document.querySelectorAll(".ouverture-modale-competence");
const fermetureModaleCompetence = document.getElementById("fermetureModaleCompetence");

const modaleCompetence = document.getElementById("modaleCompetence");

const formulaireCompetence = document.getElementById("formulaireCompetence");

const competenceId = document.getElementById("competenceId");
const nomCompetence = document.getElementById("nomCompetence");
const descriptionsCompetence = document.getElementById("descriptionsCompetence");
const coutPECompetence = document.getElementById("coutPECompetence");
const zoneEffetCompetence = document.getElementById("zoneEffetCompetence");
const modifAttaqueCompetence = document.getElementById("modifAttaqueCompetence");
const modifDefenseCompetence = document.getElementById("modifDefenseCompetence");
const modifPVCompetence = document.getElementById("modifPVCompetence");
const modifPECompetence = document.getElementById("modifPECompetence");
const modifInitiativeCompetence = document.getElementById("modifInitiativeCompetence");
const modifMouvementCompetence = document.getElementById("modifMouvementCompetence");

const typeCompetence = document.getElementById("typeCompetence");
const zoneRequisCompetence = document.getElementById("zoneRequisCompetence");
const modeleLigneRequisCompetence = document.getElementById("modeleLigneRequisCompetence");
const zoneModificateurCompetence = document.getElementById("zoneModificateurCompetence");
const modeleLigneModificateurCompetence = document.getElementById("modeleLigneModificateurCompetence");

// Ajoute une copie du modèle à la fin de la zone
function ajouterLigne(zone, modele) {
    const nouvelleLigne = modele.content.cloneNode(true);
    zone.appendChild(nouvelleLigne);
}

// Prépare une zone : une première ligne, puis une nouvelle à chaque dernière ligne remplie
function activerLignesDynamiques(zone, modele) {
    ajouterLigne(zone, modele);

    zone.addEventListener("change", function (event) {
        if (event.target.tagName !== "SELECT") {
            return;
        }
        const lignes = zone.querySelectorAll(".ligne-requis, .ligne-modificateur");
        const derniereLigne = lignes[lignes.length - 1];
        const ligneModifiee = event.target.closest(".ligne-requis, .ligne-modificateur");

        if (ligneModifiee === derniereLigne && event.target.value !== "") {
            ajouterLigne(zone, modele);
        }
    });
}

// Fonction générale de verification des champs dynamique
function verifierLignes(zone, estRequis) {
    const lignes = zone.querySelectorAll(".ligne-requis, .ligne-modificateur");
    for (const ligne of lignes) {
        const cible = ligne.querySelector("select");
        const champValeur = ligne.querySelector("input");
        effacerErreur(champValeur);
        if (cible.value === "") {
            continue;
        }
        const valeur = Number(champValeur.value);
        if (champValeur.value === "" || !Number.isInteger(valeur)) {
            afficherErreur(champValeur, "Chaque élément choisi doit avoir une valeur entière.");
            return false;
        }
        if (estRequis && valeur < 1) {
            afficherErreur(champValeur, "La valeur d'un prérequis doit être d'au moins 1.");
            return false;
        }
        if (!estRequis && valeur === 0) {
            afficherErreur(champValeur, "La valeur d'un modificateur ne peut pas être 0.");
            return false;
        }
    }
    return true;
}

function remplirLignes(zone, modele, elements) {
    for (const ligne of zone.querySelectorAll(".ligne-requis, .ligne-modificateur")) {
        ligne.remove();
    }
    for (const element of elements) {
        ajouterLigne(zone, modele);
        const lignes = zone.querySelectorAll(".ligne-requis, .ligne-modificateur");
        const derniereLigne = lignes[lignes.length - 1];
        derniereLigne.querySelector("select").value = element.cible;
        derniereLigne.querySelector("input").value = element.valeur;
    }
    ajouterLigne(zone, modele);
}

// Actions pour la modale des compétences
for (const bouton of ouvertureModaleCompetence) {
    bouton.addEventListener("click", function () {
        const donnees = JSON.parse(bouton.dataset.competence);
        const competence = donnees.competence;
        competenceId.value = competence.competenceId;
        nomCompetence.value = competence.nom;
        typeCompetence.value = competence.types;
        descriptionsCompetence.value = competence.descriptions;
        coutPECompetence.value = competence.coutPE;
        zoneEffetCompetence.value = competence.zoneEffetId ?? "";
        modifAttaqueCompetence.value = competence.modifAttaque ?? "";
        modifDefenseCompetence.value = competence.modifDefense ?? "";
        modifPVCompetence.value = competence.modifPV ?? "";
        modifPECompetence.value = competence.modifPE ?? "";
        modifInitiativeCompetence.value = competence.modifInitiative ?? "";
        modifMouvementCompetence.value = competence.modifMouvement ?? "";
        remplirLignes(zoneRequisCompetence, modeleLigneRequisCompetence, donnees.requis);
        remplirLignes(zoneModificateurCompetence, modeleLigneModificateurCompetence, donnees.modificateurs);
        modaleCompetence.classList.remove("modale-cachee");
        modaleCompetence.classList.add("modale-visible");
    });
}

if (fermetureModaleCompetence) {
    fermetureModaleCompetence.addEventListener("click", function(){
        modaleCompetence.classList.remove("modale-visible");
        modaleCompetence.classList.add("modale-cachee");
    });
};

activerLignesDynamiques(zoneRequisCompetence, modeleLigneRequisCompetence);

activerLignesDynamiques(zoneModificateurCompetence, modeleLigneModificateurCompetence);

function verifierNomCompetence() {
    const nomCompetenceTrim = nomCompetence.value.trim();
    if (nomCompetenceTrim === "") {
        afficherErreur(nomCompetence, "La compétence doit avoir un nom.");
        return false;
    }
    if (nomCompetenceTrim.length > 64) {
        afficherErreur(nomCompetence, "Le nom de la compétence ne peut excéder 64 caractères.");
        return false;
    }
    effacerErreur(nomCompetence);
    return true
}

function verifierDescriptionsCompetence() {
    const descriptionsCompetenceTrim = descriptionsCompetence.value.trim();
    if (descriptionsCompetenceTrim === "") {
        afficherErreur(descriptionsCompetence, "La compétence doit avoir une description.");
        return false;
    }
    if (descriptionsCompetenceTrim.length > 2500) {
        afficherErreur(descriptionsCompetence, "La description de la compétence ne doit pas dépasser 2500 caractères.");
        return false;
    }
    effacerErreur(descriptionsCompetence);
    return true;
}

function verifierCoutPECompetence() {
    if (typeCompetence.value === "active") {
        if (coutPECompetence.value < 1) {
            afficherErreur(coutPECompetence, "Une compétence active doit avoir au minimum un coût en points d'endurance de 1.")
            return false;
        }
        if (!Number.isInteger(Number(coutPECompetence.value))) {
            afficherErreur(coutPECompetence, "Le coût en points d'endurance de la compétence active doit être un entier.")
            return false;
        }
    } else {
        if (Number(coutPECompetence.value) !== 0) {
            afficherErreur(coutPECompetence, "Une compétence passive ne doit pas avoir de coût en points d'endurance.")
            return false;
        }
    }
    effacerErreur(coutPECompetence);
    return true
}

function verifierZoneEffetCompetence() {
    if (typeCompetence.value === "active") {
        if (zoneEffetCompetence.value === "") {
            afficherErreur(zoneEffetCompetence, "Une compétence active doit avoir une zone d'effet.")
            return false;
        }
    } else {
        if (zoneEffetCompetence.value !== "") {
            afficherErreur(zoneEffetCompetence, "Une compétence passive ne doit pas avoir une zone d'effet.")
            return false;
        }
    }
    effacerErreur(zoneEffetCompetence);
    return true
}

function verifierModifAttaqueCompetence() {
    if (!Number.isInteger(Number(modifAttaqueCompetence.value))) {
        afficherErreur(modifAttaqueCompetence, "Le modificateur d'attaque d'une compétence doit être un entier.")
        return false;
    }
    effacerErreur(modifAttaqueCompetence);
    return true
}

function verifierModifDefenseCompetence() {
    if (!Number.isInteger(Number(modifDefenseCompetence.value))) {
        afficherErreur(modifDefenseCompetence, "Le modificateur de défense d'une compétence doit être un entier.")
        return false;
    }
    effacerErreur(modifDefenseCompetence);
    return true
}

function verifierModifPVCompetence() {
    if (!Number.isInteger(Number(modifPVCompetence.value))) {
        afficherErreur(modifPVCompetence, "Le modificateur de points de vie d'une compétence doit être un entier.")
        return false;
    }
    effacerErreur(modifPVCompetence);
    return true
}

function verifierModifPECompetence() {
    if (!Number.isInteger(Number(modifPECompetence.value))) {
        afficherErreur(modifPECompetence, "Le modificateur de points d'endurance d'une compétence doit être un entier.")
        return false;
    }
    effacerErreur(modifPECompetence);
    return true
}

function verifierModifInitiativeCompetence() {
    if (!Number.isInteger(Number(modifInitiativeCompetence.value))) {
        afficherErreur(modifInitiativeCompetence, "Le modificateur d'initiative d'une compétence doit être un entier.")
        return false;
    }
    effacerErreur(modifInitiativeCompetence);
    return true
}

function verifierModifMouvementCompetence() {
    if (!Number.isInteger(Number(modifMouvementCompetence.value))) {
        afficherErreur(modifMouvementCompetence, "Le modificateur de mouvement d'une compétence doit être un entier.")
        return false;
    }
    effacerErreur(modifMouvementCompetence);
    return true
}

nomCompetence.addEventListener("blur", verifierNomCompetence);
descriptionsCompetence.addEventListener("blur", verifierDescriptionsCompetence);
coutPECompetence.addEventListener("blur", verifierCoutPECompetence);
zoneEffetCompetence.addEventListener("change", verifierZoneEffetCompetence);
typeCompetence.addEventListener("change", function() {
    verifierCoutPECompetence();
    verifierZoneEffetCompetence();
});
zoneRequisCompetence.addEventListener("focusout", function () {
    verifierLignes(zoneRequisCompetence, true);
});
zoneModificateurCompetence.addEventListener("focusout", function () {
    verifierLignes(zoneModificateurCompetence, false);
});
modifAttaqueCompetence.addEventListener("blur", verifierModifAttaqueCompetence);
modifDefenseCompetence.addEventListener("blur", verifierModifDefenseCompetence);
modifPVCompetence.addEventListener("blur", verifierModifPVCompetence);
modifPECompetence.addEventListener("blur", verifierModifPECompetence);
modifInitiativeCompetence.addEventListener("blur", verifierModifInitiativeCompetence);
modifMouvementCompetence.addEventListener("blur", verifierModifMouvementCompetence);


formulaireCompetence.addEventListener("submit", function(event) {
    if (event.submitter && event.submitter.value === "competenceSupprimer") {
        return;
    }
    let formulaireCompetenceValide = true;
    if (!verifierNomCompetence()) {
        formulaireCompetenceValide = false;
    }
    if (!verifierDescriptionsCompetence()) {
        formulaireCompetenceValide = false;
    }
    if (!verifierCoutPECompetence()) {
        formulaireCompetenceValide = false;
    }
    if (!verifierZoneEffetCompetence()) {
        formulaireCompetenceValide = false
    }
    if (!verifierLignes(zoneRequisCompetence, true)) {
        formulaireCompetenceValide = false;
    }
    if (!verifierLignes(zoneModificateurCompetence, false)) {
        formulaireCompetenceValide = false;
    }
    if (!verifierModifAttaqueCompetence()) {
        formulaireCompetenceValide = false;
    }
    if (!verifierModifDefenseCompetence()) {
        formulaireCompetenceValide = false;
    }
    if (!verifierModifPVCompetence()) {
        formulaireCompetenceValide = false;
    }
    if (!verifierModifPECompetence()) {
        formulaireCompetenceValide = false;
    }
    if (!verifierModifInitiativeCompetence()) {
        formulaireCompetenceValide = false;
    }
    if (!verifierModifMouvementCompetence()) {
        formulaireCompetenceValide = false;
    }
    if (formulaireCompetenceValide === false) {
        event.preventDefault();
    }
})
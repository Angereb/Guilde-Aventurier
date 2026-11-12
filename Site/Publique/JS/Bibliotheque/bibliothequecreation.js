// Constante des boutons récupérés
const ouvertureModaleZoneEffet = document.getElementById("ouvertureModaleZoneEffet");
const ouvertureModaleEquipement = document.getElementById("ouvertureModaleEquipement");
const ouvertureModaleMaitrise = document.getElementById("ouvertureModaleMaitrise");
const ouvertureModaleCompetence = document.getElementById("ouvertureModaleCompetence");
const fermetureModaleZoneEffet = document.getElementById("fermetureModaleZoneEffet");
const fermetureModaleEquipement = document.getElementById("fermetureModaleEquipement");
const fermetureModaleMaitrise = document.getElementById("fermetureModaleMaitrise");
const fermetureModaleCompetence = document.getElementById("fermetureModaleCompetence");

// Constante des modales
const modaleZoneEffet = document.getElementById("modaleZoneEffet");
const modaleEquipement = document.getElementById("modaleEquipement");
const modaleMaitrise = document.getElementById("modaleMaitrise");
const modaleCompetence = document.getElementById("modaleCompetence");

// Constante des formulaires
const formulaireZoneEffet = document.getElementById("formulaireZoneEffet");
const formulaireEquipement = document.getElementById("formulaireEquipement");
const formulaireMaitrise = document.getElementById("formulaireMaitrise");
const formulaireCompetence = document.getElementById("formulaireCompetence");

// Constante des champs à valider
const nomZoneEffet = document.getElementById("nomZoneEffet");
const directionsZoneEffet = document.getElementById("directionsZoneEffet");
const porteeZoneEffet = document.getElementById("porteeZoneEffet");
const iconeZoneEffet = document.getElementById("iconeZoneEffet");
const nomEquipement = document.getElementById("nomEquipement");
const categorieEquipement = document.getElementById("categorieEquipement");
const descriptionsEquipement = document.getElementById("descriptionsEquipement");
const coutPCEquipement = document.getElementById("coutPCEquipement");
const modifAttaqueEquipement = document.getElementById("modifAttaqueEquipement");
const modifDefenseEquipement = document.getElementById("modifDefenseEquipement");
const modifPVEquipement = document.getElementById("modifPVEquipement");
const modifPEEquipement = document.getElementById("modifPEEquipement");
const modifInitiativeEquipement = document.getElementById("modifInitiativeEquipement");
const modifMouvementEquipement = document.getElementById("modifMouvementEquipement");
const nomMaitrise = document.getElementById("nomMaitrise");
const descriptionsMaitrise = document.getElementById("descriptionsMaitrise");
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

// Constante spécifiques par modales
const selectionZoneEffet = document.getElementById("selectionZoneEffet");
const caseDirection= document.querySelectorAll(".case-direction");
const iconeZoneEffetImage = document.getElementById("iconeZoneEffetImage");
const iconeZoneEffetAvertissement = document.getElementById("iconeZoneEffetAvertissement");
const envoyerZoneEffet = document.getElementById("envoyerZoneEffet");
const nomFichierZoneEffet = document.getElementById("nomFichierZoneEffet");
const supprimerZoneEffet = document.getElementById("supprimerZoneEffet");

const zoneRequisEquipement = document.getElementById("zoneRequisEquipement");
const modeleLigneRequisEquipement = document.getElementById("modeleLigneRequisEquipement");
const zoneModificateurEquipement = document.getElementById("zoneModificateurEquipement");
const modeleLigneModificateurEquipement = document.getElementById("modeleLigneModificateurEquipement");

const selectionMaitrise = document.getElementById("selectionMaitrise");
const envoyerMaitrise = document.getElementById("envoyerMaitrise");
const supprimerMaitrise = document.getElementById("supprimerMaitrise");

const typeCompetence = document.getElementById("typeCompetence");
const zoneRequisCompetence = document.getElementById("zoneRequisCompetence");
const modeleLigneRequisCompetence = document.getElementById("modeleLigneRequisCompetence");
const zoneModificateurCompetence = document.getElementById("zoneModificateurCompetence");
const modeleLigneModificateurCompetence = document.getElementById("modeleLigneModificateurCompetence");

// Actions pour la modale des zones d'effets
if (ouvertureModaleZoneEffet) {
    ouvertureModaleZoneEffet.addEventListener("click", function(){
        modaleZoneEffet.classList.remove("modale-cachee");
        modaleZoneEffet.classList.add("modale-visible");
    });
};

if (fermetureModaleZoneEffet) {
    fermetureModaleZoneEffet.addEventListener("click", function(){
        modaleZoneEffet.classList.remove("modale-visible");
        modaleZoneEffet.classList.add("modale-cachee");
    });
};

selectionZoneEffet.addEventListener("change", function() {
    const optionChoisie = selectionZoneEffet.selectedOptions[0];
    if (selectionZoneEffet.value === "") {
        nomZoneEffet.value = "";
        porteeZoneEffet.value = "";
        for (const caseActuelle of caseDirection) {
            caseActuelle.checked = false;
        }
        iconeZoneEffetImage.hidden = true;
        iconeZoneEffetAvertissement.hidden = true;
        envoyerZoneEffet.textContent = "Créer";
        supprimerZoneEffet.hidden = true;
        iconeZoneEffet.value = "";
        nomFichierZoneEffet.textContent = "Aucun fichier choisi";
    } else {
        nomZoneEffet.value = optionChoisie.dataset.zoneEffetNom;
        porteeZoneEffet.value = optionChoisie.dataset.zoneEffetPortee;
        const directions = optionChoisie.dataset.zoneEffetDirections.split(",");
        for (const caseActuelle of caseDirection) {
            caseActuelle.checked = directions.includes(caseActuelle.value);
        }
        if (optionChoisie.dataset.zoneEffetIcone !== "") {
            iconeZoneEffetImage.src = optionChoisie.dataset.zoneEffetIcone;
            iconeZoneEffetImage.hidden = false;
        } else {
            iconeZoneEffetImage.hidden = true;
        }
        iconeZoneEffetAvertissement.hidden = false;
        envoyerZoneEffet.textContent = "Modifier";
        supprimerZoneEffet.hidden = false;
        iconeZoneEffet.value = "";
        nomFichierZoneEffet.textContent = "Aucun fichier choisi";
    }
})

function verifierNomZone() {
    const nomZoneEffetTrim = nomZoneEffet.value.trim();
    if (nomZoneEffetTrim === "") {
        afficherErreur(nomZoneEffet, "La zone d'effet doit avoir un nom.");
        return false;
    }
    if (nomZoneEffetTrim.length > 64) {
        afficherErreur(nomZoneEffet, "Le nom de la zone d'effet ne peut excéder 64 caractères.");
        return false;
    }
    effacerErreur(nomZoneEffet);
    return true
}

function verifierDirectionZone() {
    let auMoinsUneDirection = false;
    for (const caseActuelle of caseDirection) {
        if (caseActuelle.checked) {
            auMoinsUneDirection = true;
        }
    }
    if (auMoinsUneDirection === false) {
        afficherErreur(directionsZoneEffet, "Au moins une direction doit être désignée.");
        return false;
    }
    effacerErreur(directionsZoneEffet);
    return true;
}

function verifierPorteeZone() {
    if (porteeZoneEffet.value < 1) {
        afficherErreur(porteeZoneEffet, "La zone d'effet doit avoir au minimum une portée de 1.")
        return false;
    }
    if (!Number.isInteger(Number(porteeZoneEffet.value))) {
        afficherErreur(porteeZoneEffet, "La portée de la zone d'effet doit être un entier.")
        return false;
    }
    effacerErreur(porteeZoneEffet);
    return true
}

function verifierIconeZone() {
    const fichier = iconeZoneEffet.files[0];
    if (fichier === undefined) {
        nomFichierZoneEffet.textContent = "Aucun fichier choisi";
    } else {
        nomFichierZoneEffet.textContent = fichier.name;
    }
    if (fichier === undefined) {
        effacerErreur(iconeZoneEffet);
        return true;
    }
    if (!["image/png", "image/jpeg", "image/webp"].includes(fichier.type)) {
        afficherErreur(iconeZoneEffet, "L'icône doit être une image PNG, JPEG ou WebP.");
        return false;
    }
    if (fichier.size > 2 * 1024 * 1024) {
        afficherErreur(iconeZoneEffet, "L'icône ne doit pas dépasser 2 Mo.");
        return false;
    }
    effacerErreur(iconeZoneEffet);
    return true;
}

nomZoneEffet.addEventListener("blur", verifierNomZone);
directionsZoneEffet.addEventListener("change", verifierDirectionZone);
porteeZoneEffet.addEventListener("blur", verifierPorteeZone);
iconeZoneEffet.addEventListener("change", verifierIconeZone);

formulaireZoneEffet.addEventListener("submit", function(event) {    
    if (event.submitter && event.submitter.value === "zoneEffetSupprimer") {
        return;
    }
    let formulaireZoneEffetValide = true;
    if (!verifierNomZone()) {
        formulaireZoneEffetValide = false;
    }
    if (!verifierDirectionZone()) {
        formulaireZoneEffetValide = false;
    }
    if (!verifierPorteeZone()) {
        formulaireZoneEffetValide = false;
    }
    if (!verifierIconeZone()) {
        formulaireZoneEffetValide = false;
    }
    if (formulaireZoneEffetValide === false) {
        event.preventDefault();
    }
})

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

// Actions pour la modale des équipements
if (ouvertureModaleEquipement) {
    ouvertureModaleEquipement.addEventListener("click", function(){
        modaleEquipement.classList.remove("modale-cachee");
        modaleEquipement.classList.add("modale-visible");
    });
};

if (fermetureModaleEquipement) {
    fermetureModaleEquipement.addEventListener("click", function(){
        modaleEquipement.classList.remove("modale-visible");
        modaleEquipement.classList.add("modale-cachee");
    });
};

activerLignesDynamiques(zoneRequisEquipement, modeleLigneRequisEquipement);

activerLignesDynamiques(zoneModificateurEquipement, modeleLigneModificateurEquipement);

function verifierNomEquipement() {
    const nomEquipementTrim = nomEquipement.value.trim();
    if (nomEquipementTrim === "") {
        afficherErreur(nomEquipement, "L'équipement doit avoir un nom.");
        return false;
    }
    if (nomEquipementTrim.length > 64) {
        afficherErreur(nomEquipement, "Le nom de l'équipement ne peut excéder 64 caractères.");
        return false;
    }
    effacerErreur(nomEquipement);
    return true
}

function verifierDescriptionsEquipement() {
    const descriptionsEquipementTrim = descriptionsEquipement.value.trim();
    if (descriptionsEquipementTrim === "") {
        afficherErreur(descriptionsEquipement, "L'équipement doit avoir une description.");
        return false;
    }
    if (descriptionsEquipementTrim.length > 2500) {
        afficherErreur(descriptionsEquipement, "La description de l'équipement ne doit pas dépasser 2500 caractères.");
        return false;
    }
    effacerErreur(descriptionsEquipement);
    return true;
}

function verifierCoutPCEquipement() {
    if (coutPCEquipement.value < 1) {
        afficherErreur(coutPCEquipement, "L'équipement doit avoir au minimum un coût en points de compagnie de 1.")
        return false;
    }
    if (!Number.isInteger(Number(coutPCEquipement.value))) {
        afficherErreur(coutPCEquipement, "Le coût en points de compagnie de l'équipement doit être un entier.")
        return false;
    }
    effacerErreur(coutPCEquipement);
    return true
}

function verifierModifAttaqueEquipement() {
    if (!Number.isInteger(Number(modifAttaqueEquipement.value))) {
        afficherErreur(modifAttaqueEquipement, "Le modificateur d'attaque de l'équipement doit être un entier.")
        return false;
    }
    effacerErreur(modifAttaqueEquipement);
    return true
}

function verifierModifDefenseEquipement() {
    if (!Number.isInteger(Number(modifDefenseEquipement.value))) {
        afficherErreur(modifDefenseEquipement, "Le modificateur de défense de l'équipement doit être un entier.")
        return false;
    }
    effacerErreur(modifDefenseEquipement);
    return true
}

function verifierModifPVEquipement() {
    if (!Number.isInteger(Number(modifPVEquipement.value))) {
        afficherErreur(modifPVEquipement, "Le modificateur de points de vie de l'équipement doit être un entier.")
        return false;
    }
    effacerErreur(modifPVEquipement);
    return true
}

function verifierModifPEEquipement() {
    if (!Number.isInteger(Number(modifPEEquipement.value))) {
        afficherErreur(modifPEEquipement, "Le modificateur de points d'endurance de l'équipement doit être un entier.")
        return false;
    }
    effacerErreur(modifPEEquipement);
    return true
}

function verifierModifInitiativeEquipement() {
    if (!Number.isInteger(Number(modifInitiativeEquipement.value))) {
        afficherErreur(modifInitiativeEquipement, "Le modificateur d'initiative de l'équipement doit être un entier.")
        return false;
    }
    effacerErreur(modifInitiativeEquipement);
    return true
}

function verifierModifMouvementEquipement() {
    if (!Number.isInteger(Number(modifMouvementEquipement.value))) {
        afficherErreur(modifMouvementEquipement, "Le modificateur de mouvement de l'équipement doit être un entier.")
        return false;
    }
    effacerErreur(modifMouvementEquipement);
    return true
}

nomEquipement.addEventListener("blur", verifierNomEquipement);
descriptionsEquipement.addEventListener("blur", verifierDescriptionsEquipement);
coutPCEquipement.addEventListener("blur", verifierCoutPCEquipement);
zoneRequisEquipement.addEventListener("focusout", function () {
    verifierLignes(zoneRequisEquipement, true);
});
zoneModificateurEquipement.addEventListener("focusout", function () {
    verifierLignes(zoneModificateurEquipement, false);
});
modifAttaqueEquipement.addEventListener("blur", verifierModifAttaqueEquipement);
modifDefenseEquipement.addEventListener("blur", verifierModifDefenseEquipement);
modifPVEquipement.addEventListener("blur", verifierModifPVEquipement);
modifPEEquipement.addEventListener("blur", verifierModifPEEquipement);
modifInitiativeEquipement.addEventListener("blur", verifierModifInitiativeEquipement);
modifMouvementEquipement.addEventListener("blur", verifierModifMouvementEquipement);


formulaireEquipement.addEventListener("submit", function(event) {
    let formulaireEquipementValide = true;
    if (!verifierNomEquipement()) {
        formulaireEquipementValide = false;
    }
    if (!verifierDescriptionsEquipement()) {
        formulaireEquipementValide = false;
    }
    if (!verifierCoutPCEquipement()) {
        formulaireEquipementValide = false;
    }
    if (!verifierLignes(zoneRequisEquipement, true)) {
        formulaireEquipementValide = false;
    }
    if (!verifierLignes(zoneModificateurEquipement, false)) {
        formulaireEquipementValide = false;
    }
    if (!verifierModifAttaqueEquipement()) {
        formulaireEquipementValide = false;
    }
    if (!verifierModifDefenseEquipement()) {
        formulaireEquipementValide = false;
    }
    if (!verifierModifPVEquipement()) {
        formulaireEquipementValide = false;
    }
    if (!verifierModifPEEquipement()) {
        formulaireEquipementValide = false;
    }
    if (!verifierModifInitiativeEquipement()) {
        formulaireEquipementValide = false;
    }
    if (!verifierModifMouvementEquipement()) {
        formulaireEquipementValide = false;
    }
    if (formulaireEquipementValide === false) {
        event.preventDefault();
    }
})

// Actions pour la modale des maîtrises
if (ouvertureModaleMaitrise) {
    ouvertureModaleMaitrise.addEventListener("click", function(){
        modaleMaitrise.classList.remove("modale-cachee");
        modaleMaitrise.classList.add("modale-visible");
    });
};

if (fermetureModaleMaitrise) {
    fermetureModaleMaitrise.addEventListener("click", function(){
        modaleMaitrise.classList.remove("modale-visible");
        modaleMaitrise.classList.add("modale-cachee");
    });
};

selectionMaitrise.addEventListener("change", function() {
    const optionChoisie = selectionMaitrise.selectedOptions[0];
    if (selectionMaitrise.value === "") {
        nomMaitrise.value = "";
        descriptionsMaitrise.value = "";
        envoyerMaitrise.textContent = "Créer";
        supprimerMaitrise.hidden = true;
    } else {
        nomMaitrise.value = optionChoisie.dataset.maitriseNom;
        descriptionsMaitrise.value = optionChoisie.dataset.maitriseDescriptions;
        envoyerMaitrise.textContent = "Modifier";
        supprimerMaitrise.hidden = false;
    }
})

function verifierNomMaitrise() {
    const nomMaitriseTrim = nomMaitrise.value.trim();
    if (nomMaitriseTrim === "") {
        afficherErreur(nomMaitrise, "La maîtrise doit avoir un nom.");
        return false;
    }
    if (nomMaitriseTrim.length > 64) {
        afficherErreur(nomMaitrise, "Le nom de la maîtrise ne peut excéder 64 caractères.");
        return false;
    }
    effacerErreur(nomMaitrise);
    return true
}

function verifierDescriptionsMaitrise() {
    const descriptionsMaitriseTrim = descriptionsMaitrise.value.trim();
    if (descriptionsMaitriseTrim === "") {
        afficherErreur(descriptionsMaitrise, "La maîtrise doit avoir une description.");
        return false;
    }
    if (descriptionsMaitriseTrim.length > 2500) {
        afficherErreur(descriptionsMaitrise, "La description de la maîtrise ne doit pas dépasser 2500 caractères.");
        return false;
    }
    effacerErreur(descriptionsMaitrise);
    return true;
}

nomMaitrise.addEventListener("blur", verifierNomMaitrise);
descriptionsMaitrise.addEventListener("blur", verifierDescriptionsMaitrise);

formulaireMaitrise.addEventListener("submit", function(event) {
    if (event.submitter && event.submitter.value === "maitriseSupprimer") {
        return;
    }
    let formulaireMaitriseValide = true;
    if (!verifierNomMaitrise()) {
        formulaireMaitriseValide = false;
    }
    if (!verifierDescriptionsMaitrise()) {
        formulaireMaitriseValide = false;
    }
    if (formulaireMaitriseValide === false) {
        event.preventDefault();
    }
})

// Actions pour la modale des compétences
if (ouvertureModaleCompetence) {
    ouvertureModaleCompetence.addEventListener("click", function(){
        modaleCompetence.classList.remove("modale-cachee");
        modaleCompetence.classList.add("modale-visible");
    });
};

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
const ouvertureModaleEquipement = document.querySelectorAll(".ouverture-modale-equipement");
const fermetureModaleEquipement = document.getElementById("fermetureModaleEquipement");

const modaleEquipement = document.getElementById("modaleEquipement");

const formulaireEquipement = document.getElementById("formulaireEquipement");

const equipementId = document.getElementById("equipementId");
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

const zoneRequisEquipement = document.getElementById("zoneRequisEquipement");
const modeleLigneRequisEquipement = document.getElementById("modeleLigneRequisEquipement");
const zoneModificateurEquipement = document.getElementById("zoneModificateurEquipement");
const modeleLigneModificateurEquipement = document.getElementById("modeleLigneModificateurEquipement");

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

// Actions pour la modale des équipements
for (const bouton of ouvertureModaleEquipement) {
    bouton.addEventListener("click", function () {
        const donnees = JSON.parse(bouton.dataset.equipement);
        const equipement = donnees.equipement;

        equipementId.value = equipement.equipementId;
        nomEquipement.value = equipement.nom;
        categorieEquipement.value = equipement.categorie;
        descriptionsEquipement.value = equipement.descriptions;
        coutPCEquipement.value = equipement.coutPC;
        modifAttaqueEquipement.value = equipement.modifAttaque ?? "";
        modifDefenseEquipement.value = equipement.modifDefense ?? "";
        modifPVEquipement.value = equipement.modifPV ?? "";
        modifPEEquipement.value = equipement.modifPE ?? "";
        modifInitiativeEquipement.value = equipement.modifInitiative ?? "";
        modifMouvementEquipement.value = equipement.modifMouvement ?? "";

        remplirLignes(zoneRequisEquipement, modeleLigneRequisEquipement, donnees.requis);
        remplirLignes(zoneModificateurEquipement, modeleLigneModificateurEquipement, donnees.modificateurs);

        modaleEquipement.classList.remove("modale-cachee");
        modaleEquipement.classList.add("modale-visible");
    });
}

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
    if (event.submitter && event.submitter.value === "equipementSupprimer") {
        return;
    }
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
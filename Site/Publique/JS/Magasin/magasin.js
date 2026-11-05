// Constante pour la gestion de la modale
const fermetureMagasin = document.getElementById("fermetureMagasin");
const validationMagasin = document.getElementById("validationMagasin");
const modaleMagasin = document.getElementById("modaleMagasin");

// Constante des filtres
const filtreCategorie = document.getElementById("filtreCategorie");
const filtreCaracteristique = document.getElementById("filtreCaracteristique");
const filtreMaitrise = document.getElementById("filtreMaitrise");

// Constante des templates
const modeleEquipementdetaille = document.getElementById("modeleEquipementdetaille");
const modeleEquipementInventaire = document.getElementById("modeleEquipementInventaire");

// Constante des listes recevant les templates
const equipementCatalogue = document.getElementById("equipementCatalogue");
const equipementInventaire = document.getElementById("equipementInventaire");

// Constante du total du coût en PC
const totalPC = document.getElementById("totalPC");

let inventaireActuel = [];
let renvoyerPanier = null;
let inventairePanier = [];

function possedeRequis(objet, cibleCherchee) {
    for (const requis of objet.requis) {
        if (requis.cible === cibleCherchee) {
            return true;
        }
    }
    return false;
}

function afficherCatalogue() {
    const equipements = DONNEES_FICHE["equipements"];
    let catalogue = [];
    for (const equipement of equipements) {
        if ((filtreCategorie.value === "" || equipement.equipement.categorie === filtreCategorie.value)
            && (filtreCaracteristique.value === "" || possedeRequis(equipement, "caracteristique-" + filtreCaracteristique.value))
            && (filtreMaitrise.value === "" || possedeRequis(equipement, "maitrise-" + filtreMaitrise.value))) {
            catalogue.push(equipement);
        }
    }
    equipementCatalogue.innerHTML = "";
    for (const equipement of catalogue) {
        const ficheEquipement = modeleEquipementdetaille.content.cloneNode(true);
        for (const requis of equipement.requis) {
            const ligneRequis = document.createElement("li");
            ligneRequis.textContent = requis.nom + " : " + requis.valeur;
            ficheEquipement.querySelector(".affichage-requis").appendChild(ligneRequis);
        }
        ficheEquipement.querySelector(".affichage-nom").textContent = equipement.equipement.nom;
        ficheEquipement.querySelector(".affichage-description").textContent = equipement.equipement.descriptions;
        for (const modificateur of equipement.modificateurs) {
            const lignemodificateur = document.createElement("li");
            lignemodificateur.textContent = modificateur.nom + " : " + modificateur.valeur;
            ficheEquipement.querySelector(".affichage-modificateur-principaux").appendChild(lignemodificateur);
        }
        if (equipement.equipement.modifAttaque !== null) {
            ficheEquipement.querySelector(".affichage-modificateur-attaque").textContent = "Attaque : " + equipement.equipement.modifAttaque;
        } else {
            ficheEquipement.querySelector(".affichage-modificateur-attaque").hidden = true;
        }
        if (equipement.equipement.modifDefense !== null) {
            ficheEquipement.querySelector(".affichage-modificateur-defense").textContent = "Défense : " + equipement.equipement.modifDefense;
        } else {
            ficheEquipement.querySelector(".affichage-modificateur-defense").hidden = true;
        }
        if (equipement.equipement.modifPV !== null) {
            ficheEquipement.querySelector(".affichage-modificateur-pv").textContent = "PV : " + equipement.equipement.modifPV;
        } else {
            ficheEquipement.querySelector(".affichage-modificateur-pv").hidden = true;
        }
        if (equipement.equipement.modifPE !== null) {
            ficheEquipement.querySelector(".affichage-modificateur-pe").textContent = "PE : " +equipement.equipement.modifPE;
        } else {
            ficheEquipement.querySelector(".affichage-modificateur-pe").hidden = true;
        }
        if (equipement.equipement.modifInitiative !== null) {
            ficheEquipement.querySelector(".affichage-modificateur-initiative").textContent = "Initiative : " + equipement.equipement.modifInitiative;
        } else {
            ficheEquipement.querySelector(".affichage-modificateur-initiative").hidden = true;
        }
        if (equipement.equipement.modifMouvement !== null) {
            ficheEquipement.querySelector(".affichage-modificateur-mouvement").textContent = "Mouvement : " + equipement.equipement.modifMouvement;
        } else {
            ficheEquipement.querySelector(".affichage-modificateur-mouvement").hidden = true;
        }
        ficheEquipement.querySelector(".affichage-cout").textContent = "Coût en PC : " + equipement.equipement.coutPC;
        ficheEquipement.querySelector(".ajouter-equipement").dataset.equipementId = equipement.equipement.equipementId;
        equipementCatalogue.appendChild(ficheEquipement);
    }
}

filtreCategorie.addEventListener("change", afficherCatalogue);
filtreCaracteristique.addEventListener("change", afficherCatalogue);
filtreMaitrise.addEventListener("change", afficherCatalogue);

function afficherPanier() {
    equipementInventaire.innerHTML = "";
    let total = 0;
    for (const equipement of inventairePanier) {
        const ficheInventaire = modeleEquipementInventaire.content.cloneNode(true);
        ficheInventaire.querySelector(".equipement-nom").textContent = equipement.nom;
        ficheInventaire.querySelector(".quantite-input").value = equipement.quantite;
        ficheInventaire.querySelector(".quantite-input").dataset.equipementId = equipement.equipementId;
        ficheInventaire.querySelector(".equipement-etat").textContent = equipement.etat;
        let coutEquipements = equipement.coutPC * equipement.quantite;
        ficheInventaire.querySelector(".equipement-cout").textContent = coutEquipements + " PC";
        ficheInventaire.querySelector(".supprimer-equipement").dataset.equipementId = equipement.equipementId;
        equipementInventaire.appendChild(ficheInventaire);
        total = total + coutEquipements;
    }
    totalPC.textContent = "Total coût : " + total + " PC";
}

function ajouterPanier(equipementId) {
    let equipementTrouve = null;
    for (const equipement of inventairePanier) {
        if (equipement.equipementId === equipementId) {
            equipementTrouve = equipement;
        } 
    }
    if (equipementTrouve !== null) {
        equipementTrouve.quantite = equipementTrouve.quantite +1;
    } else {
        for (const objetCatalogue of DONNEES_FICHE.equipements) {
            if (objetCatalogue.equipement.equipementId === equipementId) {
                inventairePanier.push({
                    equipementId: objetCatalogue.equipement.equipementId,
                    categorie: objetCatalogue.equipement.categorie,
                    nom: objetCatalogue.equipement.nom,
                    quantite: 1,
                    etat: "inventaire",
                    coutPC: objetCatalogue.equipement.coutPC
                });
            }
        }
    }
    afficherPanier();
}

equipementCatalogue.addEventListener("click", function(event) {
    const boutonAchat = event.target.closest(".ajouter-equipement");
    if (boutonAchat === null) {
        return;
    }
    ajouterPanier(Number(boutonAchat.dataset.equipementId));
})

function supprimerPanier(equipementId) {
    let equipementGardes = [];
    for (const equipement of inventairePanier) {
        if (equipement.equipementId !== equipementId) {
            equipementGardes.push(equipement);
        }
    }
    inventairePanier = equipementGardes;
    afficherPanier();
}

function modifierQuantite(equipementId, quantite) {
    let equipementTrouve = null;
    for (const equipement of inventairePanier) {
        if (equipement.equipementId === equipementId) {
            equipementTrouve = equipement;
        } 
    }
    if (quantite < 1) {
        supprimerPanier(equipementTrouve.equipementId);
        return;
    }
    equipementTrouve.quantite = Math.floor(quantite);
    afficherPanier();
}

equipementInventaire.addEventListener("change", function(event) {
    const champQuantite = event.target.closest(".quantite-input");
    if (champQuantite === null) {
        return;
    }
    let equipementModifieId = Number(champQuantite.dataset.equipementId);
    let equipementModifieQuantite = Number(champQuantite.value);
    modifierQuantite(equipementModifieId, equipementModifieQuantite);
})

equipementInventaire.addEventListener("click", function(event) {
    const boutonSupprimer = event.target.closest(".supprimer-equipement");
    if (boutonSupprimer === null) {
        return;
    }
    supprimerPanier(Number(boutonSupprimer.dataset.equipementId));
})

function ouvrirMagasin(inventaireFiche, recupererPanier) {
    inventaireActuel = inventaireFiche;
    inventairePanier = structuredClone(inventaireActuel);
    renvoyerPanier = recupererPanier;
    afficherCatalogue();
    afficherPanier();
    modaleMagasin.classList.remove("modale-cachee");
    modaleMagasin.classList.add("modale-visible");
}

fermetureMagasin.addEventListener("click", function() {
    modaleMagasin.classList.remove("modale-visible");
    modaleMagasin.classList.add("modale-cachee");
})

validationMagasin.addEventListener("click", function() {
    renvoyerPanier(inventairePanier);
    modaleMagasin.classList.remove("modale-visible");
    modaleMagasin.classList.add("modale-cachee");
})
// Constante des boutons récupérés
const boutonModifGeneralOuvrir = document.getElementById("modifierGeneral");
const boutonModifGeneralFermer = document.getElementById("fermerModifierGeneral");
const boutonModifMotDePasseOuvrir = document.getElementById("modifierMotDePasse");
const boutonModifMotDePasseFermer = document.getElementById("fermerModifierMotDePasse");
const boutonSupprimerCompteOuvrir = document.getElementById("supprimerCompte");
const boutonSupprimerCompteFermer = document.getElementById("fermerSupprimerCompte");

// Constante des modales
const modaleGeneral = document.getElementById("modaleGeneral");
const modaleMotDePasse = document.getElementById("modaleMotDePasse");
const modaleSupprimerCompte = document.getElementById("modaleSupprimerCompte");

// Constante des formulaires
const formulaireGeneral = document.getElementById("formulaireGeneral");
const formulaireMotDePasse = document.getElementById("formulaireMotDePasse");
const formulaireSupprimerCompte = document.getElementById("formulaireSupprimerCompte");

// Constante des champs à valider
const pseudoInput = document.getElementById("pseudoInput");
const nomDeCompagnieInput = document.getElementById("nomDeCompagnieInput");
const emailInput = document.getElementById("emailInput");
const motDePasseInput = document.getElementById("motDePasseInput");
const modificationVerificationMotDePasseInput = document.getElementById("modificationVerificationMotDePasseInput");
const verifInputGeneral = document.getElementById("verifInputGeneral");
const verifInputMotDePasse = document.getElementById("verifInputMotDePasse");
const verifInputSupprimerCompte = document.getElementById("verifInputSupprimerCompte");   

// Fermeture modale de modification générale
if (boutonModifGeneralFermer) {
    boutonModifGeneralFermer.addEventListener("click", function(){
        modaleGeneral.classList.remove("modale-visible");
        modaleGeneral.classList.add("modale-cachee");
    });
}   

// Fermeture modale de modification de mot de passe
if (boutonModifMotDePasseFermer) {
    boutonModifMotDePasseFermer.addEventListener("click", function(){
        modaleMotDePasse.classList.remove("modale-visible");
        modaleMotDePasse.classList.add("modale-cachee");
    });
}

// Ouverture modale de suppression
if (boutonSupprimerCompteOuvrir) {
    boutonSupprimerCompteOuvrir.addEventListener("click", function(){
        modaleSupprimerCompte.classList.remove("modale-cachee");
        modaleSupprimerCompte.classList.add("modale-visible");
    });
} 

// Fermeture modale de suppression
if (boutonSupprimerCompteFermer) {
    boutonSupprimerCompteFermer.addEventListener("click", function(){
        modaleSupprimerCompte.classList.remove("modale-visible");
        modaleSupprimerCompte.classList.add("modale-cachee");
    });
}

// Validation des entrées dans le formulaire de modification générale
function verifierPseudo() {
    const pseudoInputTrim = pseudoInput.value.trim();
    if (pseudoInputTrim === "") {
        afficherErreur(pseudoInput, "Le pseudo ne peut pas être vide.");
        return false;
    }
    if (pseudoInputTrim.length > 64) {
        afficherErreur(pseudoInput, "Le pseudo ne peut pas dépasser 64 caractères.");
        return false;
    }
    const regexPseudo = /^[a-zA-ZÀ-ÖØ-öø-ÿ0-9_-]+$/u;
    if (!regexPseudo.test(pseudoInputTrim)) {
        afficherErreur(pseudoInput, "Le pseudo ne peut contenir que des lettres, des chiffres, des tirets et des underscores.");
        return false;
    }
    effacerErreur(pseudoInput);
    return true;
};

function verifierNomDeCompagnie() {
    const nomDeCompagnieInputTrim = nomDeCompagnieInput.value.trim();
    if (nomDeCompagnieInputTrim === "") {
        afficherErreur(nomDeCompagnieInput, "Le nom de la compagnie ne peut pas être vide.");
        return false;
    }
    if (nomDeCompagnieInputTrim.length > 128) {
        afficherErreur(nomDeCompagnieInput, "Le nom de la compagnie ne peut pas dépasser 128 caractères.");
        return false;
    }
    const regexNomDeCompagnie = /^[a-zA-ZÀ-ÖØ-öø-ÿ0-9' _-]+$/u;
    if (!regexNomDeCompagnie.test(nomDeCompagnieInputTrim)) {
        afficherErreur(nomDeCompagnieInput, "Le nom de la compagnie ne peut contenir que des lettres, des chiffres, des tirets, des underscores, des apostrophes et des espaces.");
        return false;
    }
    effacerErreur(nomDeCompagnieInput);
    return true;
};

function verifierEmail() {
    const emailInputTrim = emailInput.value.trim();
    if (emailInputTrim === "") {
        afficherErreur(emailInput, "L'adresse mail ne peut pas être vide.");
        return false;
    }
    if (emailInputTrim.length > 128) {
        afficherErreur(emailInput, "L'adresse mail ne peut pas dépasser 128 caractères.");
        return false;
    }
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(emailInputTrim)) {
        afficherErreur(emailInput, "L'adresse mail n'est pas valide.");
        return false;
    }
    effacerErreur(emailInput);
    return true;
};

pseudoInput.addEventListener("blur", verifierPseudo);

nomDeCompagnieInput.addEventListener("blur", verifierNomDeCompagnie);

emailInput.addEventListener("blur", verifierEmail);

boutonModifGeneralOuvrir.addEventListener("click", function() {
    let presFormulaireGeneralValide = true;
    if (!verifierPseudo()) {
        presFormulaireGeneralValide = false;
    }
    if (!verifierNomDeCompagnie()) {
        presFormulaireGeneralValide = false;
    }
    if (!verifierEmail()) {
        presFormulaireGeneralValide = false;
    }
    if (presFormulaireGeneralValide === true) {
        modaleGeneral.classList.remove("modale-cachee");
        modaleGeneral.classList.add("modale-visible");
    }
});

formulaireGeneral.addEventListener("submit", function(event) {
    let formulaireGeneralValide = true;
    if (verifInputGeneral.value === "") {
        afficherErreur(verifInputGeneral, "Le mot de passe ne peut être vide.");
        formulaireGeneralValide = false;
    } else {
        effacerErreur(verifInputGeneral);
    }
    if (formulaireGeneralValide === false) {
        event.preventDefault();
    }
});

// Validation des entrées dans le formulaire de modification du mot de passe
function verifierMotDePasse() {
    if (motDePasseInput.value === "") {
        afficherErreur(motDePasseInput, "Le mot de passe ne peut pas être vide.");
        return false;
    }
    if (motDePasseInput.value.length > 72) {
        afficherErreur(motDePasseInput, "Le mot de passe est trop long.");
        return false;
    }
    const regexMotDePasse = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,72}$/u;
    if (!regexMotDePasse.test(motDePasseInput.value)) {
        afficherErreur(motDePasseInput, "Le mot de passe doit contenir au minimum 8 caractères et au moins une minuscule, une majuscule, un chiffre et un caractère spécial.");
        return false;
    }
    effacerErreur(motDePasseInput);
    return true;
};

motDePasseInput.addEventListener("blur", verifierMotDePasse);

boutonModifMotDePasseOuvrir.addEventListener("click", function() {
    let presFormulaireMotDePasseValide = true;
    if (!verifierMotDePasse()) {
        presFormulaireMotDePasseValide = false;
    }
    if (modificationVerificationMotDePasseInput.value !== motDePasseInput.value) {
        afficherErreur(modificationVerificationMotDePasseInput, "Les deux mots de passe ne sont pas identiques.");
        presFormulaireMotDePasseValide = false;
    } else {
        effacerErreur(modificationVerificationMotDePasseInput);
    }
    if (presFormulaireMotDePasseValide === true) {
        modaleMotDePasse.classList.remove("modale-cachee");
        modaleMotDePasse.classList.add("modale-visible");
    }
});

formulaireMotDePasse.addEventListener("submit", function(event) {
    let formulaireMotDePasseValide = true;
    if (verifInputMotDePasse.value === "") {
        afficherErreur(verifInputMotDePasse, "Le mot de passe ne peut être vide.");
        formulaireMotDePasseValide = false;
    } else {
        effacerErreur(verifInputMotDePasse);
    }
    if (formulaireMotDePasseValide === false) {
        event.preventDefault();
    }
});

// Validation des entrées dans le formulaire de suppression de compte
formulaireSupprimerCompte.addEventListener("submit", function(event) {
    let formulaireSuppressionValide = true;
    if (verifInputSupprimerCompte.value === "") {
        afficherErreur(verifInputSupprimerCompte, "Le mot de passe ne peut être vide.");
        formulaireSuppressionValide = false;
    } else {
        effacerErreur(verifInputSupprimerCompte);
    }
    if (formulaireSuppressionValide === false) {
        event.preventDefault();
    }
});
const formulaireInscription = document.getElementById("formulaireInscription");
const inscriptionPseudoInput = document.getElementById("inscriptionPseudoInput");
const inscriptionNomDeCompagnieInput = document.getElementById("inscriptionNomDeCompagnieInput");
const inscriptionEmailInput = document.getElementById("inscriptionEmailInput");
const inscriptionMotDePasseInput = document.getElementById("inscriptionMotDePasseInput");
const inscriptionVerificationMotDePasseInput = document.getElementById("inscriptionVerificationMotDePasseInput");

function verifierPseudo() {
    const inscriptionPseudoInputTrim = inscriptionPseudoInput.value.trim();
    if (inscriptionPseudoInputTrim === "") {
        afficherErreur(inscriptionPseudoInput, "Le pseudo ne peut pas être vide.");
        return false;
    }
    if (inscriptionPseudoInputTrim.length > 64) {
        afficherErreur(inscriptionPseudoInput, "Le pseudo ne peut pas dépasser 64 caractères.");
        return false;
    }
    const regexPseudo = /^[a-zA-ZÀ-ÖØ-öø-ÿ0-9_-]+$/u;
    if (!regexPseudo.test(inscriptionPseudoInputTrim)) {
        afficherErreur(inscriptionPseudoInput, "Le pseudo ne peut contenir que des lettres, des chiffres, des tirets et des underscores.");
        return false;
    }
    effacerErreur(inscriptionPseudoInput);
    return true;
};

function verifierNomDeCompagnie() {
    const inscriptionNomDeCompagnieInputTrim = inscriptionNomDeCompagnieInput.value.trim();
    if (inscriptionNomDeCompagnieInputTrim === "") {
        afficherErreur(inscriptionNomDeCompagnieInput, "Le nom de la compagnie ne peut pas être vide.");
        return false;
    }
    if (inscriptionNomDeCompagnieInputTrim.length > 128) {
        afficherErreur(inscriptionNomDeCompagnieInput, "Le nom de la compagnie ne peut pas dépasser 128 caractères.");
        return false;
    }
    const regexNomDeCompagnie = /^[a-zA-ZÀ-ÖØ-öø-ÿ0-9' _-]+$/u;
    if (!regexNomDeCompagnie.test(inscriptionNomDeCompagnieInputTrim)) {
        afficherErreur(inscriptionNomDeCompagnieInput, "Le nom de la compagnie ne peut contenir que des lettres, des chiffres, des tirets, des underscores, des apostrophes et des espaces.");
        return false;
    }
    effacerErreur(inscriptionNomDeCompagnieInput);
    return true;
};

function verifierEmail() {
    const inscriptionEmailInputTrim = inscriptionEmailInput.value.trim();
    if (inscriptionEmailInputTrim === "") {
        afficherErreur(inscriptionEmailInput, "L'adresse mail ne peut pas être vide.");
        return false;
    }
    if (inscriptionEmailInputTrim.length > 128) {
        afficherErreur(inscriptionEmailInput, "L'adresse mail ne peut pas dépasser 128 caractères.");
        return false;
    }
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(inscriptionEmailInputTrim)) {
        afficherErreur(inscriptionEmailInput, "L'adresse mail n'est pas valide.");
        return false;
    }
    effacerErreur(inscriptionEmailInput);
    return true;
};

function verifierMotDePasse() {
    if (inscriptionMotDePasseInput.value === "") {
        afficherErreur(inscriptionMotDePasseInput, "Le mot de passe ne peut pas être vide.");
        return false;
    }
    if (inscriptionMotDePasseInput.value.length > 72) {
        afficherErreur(inscriptionMotDePasseInput, "Le mot de passe est trop long.");
        return false;
    }
    const regexMotDePasse = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^a-zA-Z0-9]).{8,72}$/u;
    if (!regexMotDePasse.test(inscriptionMotDePasseInput.value)) {
        afficherErreur(inscriptionMotDePasseInput, "Le mot de passe doit contenir au minimum 8 caractères et au moins une minuscule, une majuscule, un chiffre et un caractère spécial.");
        return false;
    }
    effacerErreur(inscriptionMotDePasseInput);
    return true;
};

inscriptionPseudoInput.addEventListener("blur", verifierPseudo);

inscriptionNomDeCompagnieInput.addEventListener("blur", verifierNomDeCompagnie);

inscriptionEmailInput.addEventListener("blur", verifierEmail);

inscriptionMotDePasseInput.addEventListener("blur", verifierMotDePasse);

formulaireInscription.addEventListener("submit", function(event) {
    let formulaireInscriptionValide = true;
    if (!verifierPseudo()) {
        formulaireInscriptionValide = false;
    }
    if (!verifierNomDeCompagnie()) {
        formulaireInscriptionValide = false;
    }
    if (!verifierEmail()) {
        formulaireInscriptionValide = false;
    }
    if (!verifierMotDePasse()) {
        formulaireInscriptionValide = false;
    }
    if (inscriptionVerificationMotDePasseInput.value !== inscriptionMotDePasseInput.value) {
        afficherErreur(inscriptionVerificationMotDePasseInput, "Les deux mots de passe ne sont pas identiques.");
        formulaireInscriptionValide = false;
    } else {
        effacerErreur(inscriptionVerificationMotDePasseInput);
    }
    if (formulaireInscriptionValide === false) {
        event.preventDefault();
    }
});
const formulaireContact = document.getElementById("formulaireContact");
const creerContactInput = document.getElementById("creerContactInput");

formulaireContact.addEventListener("submit", function(event) {
    const creerContactInputTrim = creerContactInput.value.trim();
    let formulaireContactValide = true;
    if (creerContactInputTrim === "") {
        afficherErreur(creerContactInput, "Le champ ne peut être vide.");
        formulaireContactValide = false;
    } else {
        effacerErreur(creerContactInput);
    }
    if (formulaireContactValide === false) {
        event.preventDefault();
    }
});
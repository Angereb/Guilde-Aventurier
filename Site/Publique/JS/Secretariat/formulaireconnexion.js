const formulaireConnexion = document.getElementById("formulaireConnexion");
const connexionIdentifiantInput = document.getElementById("connexionIdentifiantInput");
const connexionMotDePasseInput = document.getElementById("connexionMotDePasseInput");

formulaireConnexion.addEventListener("submit", function(event) {
    const connexionIdentifiantInputTrim = connexionIdentifiantInput.value.trim();
    const connexionMotDePasseInputtrim = connexionMotDePasseInput.value.trim();
    let formulaireConnexionValide = true;
    if (connexionIdentifiantInputTrim === "") {
        afficherErreur(connexionIdentifiantInput, "L'identifiant ne peut être vide.");
        formulaireConnexionValide = false;
    } else {
        effacerErreur(connexionIdentifiantInput);
    }
    if (connexionMotDePasseInputtrim === "") {
        afficherErreur(connexionMotDePasseInput, "Le mot de passe ne peut être vide.");
        formulaireConnexionValide = false;
    } else {
        effacerErreur(connexionMotDePasseInput);
    }
    if (formulaireConnexionValide === false) {
        event.preventDefault();
    }
});
// Constante des boutons récupérés
const ecrireOuverture = document.getElementById("ecrireOuverture");
const fermerRedactionMessage = document.getElementById("fermerRedactionMessage");
const ouvertureLectureMessage = document.querySelectorAll(".ouverture-message");
const fermerLectureMessage = document.getElementById("fermerLectureMessage");

// Constante des modales
const modaleRedactionMessage = document.getElementById("modaleRedactionMessage");
const modaleLectureMessage = document.getElementById("modaleLectureMessage");

// Constante du formulaire
const formulaireEnvoiMessage = document.getElementById("formulaireEnvoiMessage");

// Constante des champs à valider
const destinataireInput = document.getElementById("destinataireInput");
const titreInput = document.getElementById("titreInput");
const contenuInput = document.getElementById("contenuInput");

// Constante du contenu de lecture
const lectureTitre = document.getElementById("lectureTitre");
const lectureExpediteur = document.getElementById("lectureExpediteur");
const lectureContenu = document.getElementById("lectureContenu");
const lectureDate = document.getElementById("lectureDate");

// Constante du jeton CSRF
const jetonCsrf = formulaireEnvoiMessage.querySelector('input[name="jetonCsrf"]').value;

// Validation des entrées dans le formulaire de redaction de message
function verifierPseudo() {
    const destinataireInputTrim = destinataireInput.value.trim();
    if (destinataireInputTrim === "") {
        afficherErreur(destinataireInput, "Le pseudo ne peut pas être vide.");
        return false;
    }
    if (destinataireInputTrim.length > 64) {
        afficherErreur(destinataireInput, "Le pseudo ne peut pas dépasser 64 caractères.");
        return false;
    }
    const regexPseudo = /^[a-zA-ZÀ-ÖØ-öø-ÿ0-9_-]+$/u;
    if (!regexPseudo.test(destinataireInputTrim)) {
        afficherErreur(destinataireInput, "Le pseudo ne peut contenir que des lettres, des chiffres, des tirets et des underscores.");
        return false;
    }
    effacerErreur(destinataireInput);
    return true;
};

destinataireInput.addEventListener("blur", verifierPseudo);

ecrireOuverture.addEventListener("click", function() {
    let presFormulaireEnvoiMessageValide = true;
    if (!verifierPseudo()) {
        presFormulaireEnvoiMessageValide = false;
    }
    if (presFormulaireEnvoiMessageValide === true) {
        modaleRedactionMessage.classList.remove("modale-cachee");
        modaleRedactionMessage.classList.add("modale-visible");
    }
});

function verifierTitre() {
    const titreInputTrim = titreInput.value.trim();
    if (titreInputTrim === "") {
        afficherErreur(titreInput, "Le message doit avoir un titre.");
        return false;
    }
    if (titreInputTrim.length > 128) {
        afficherErreur(titreInput, "Le titre du message ne peut excéder 128 caractères.");
        return false;
    }
    effacerErreur(titreInput);
    return true
};

function verifierContenu() {
    const contenuInputTrim = contenuInput.value.trim();
    if (contenuInputTrim === "") {
        afficherErreur(contenuInput, "Le message doit avoir un contenu.");
        return false;
    }
    if (contenuInputTrim.length > 2500) {
        afficherErreur(contenuInput, "Le contenu du message ne doit pas dépasser 2500 caractères.");
        return false;
    }
    effacerErreur(contenuInput);
    return true;
};

titreInput.addEventListener("blur", verifierTitre);

contenuInput.addEventListener("blur", verifierContenu);

formulaireEnvoiMessage.addEventListener("submit", function(event) {
    let formulaireEnvoiMessageValide = true;
    if (!verifierTitre()) {
        formulaireEnvoiMessageValide = false;
    }
    if (!verifierContenu()) {
        formulaireEnvoiMessageValide = false;
    }
    if (formulaireEnvoiMessageValide === false) {
        event.preventDefault();
    }
});

// Fermeture modale de rédaction de message
if (fermerRedactionMessage) {
    fermerRedactionMessage.addEventListener("click", function(){
        modaleRedactionMessage.classList.remove("modale-visible");
        modaleRedactionMessage.classList.add("modale-cachee");
    });
};

// Ouverture modale de lecture et remplissage du message
for (const messageLu of ouvertureLectureMessage) {
    messageLu.addEventListener("click", function(){
        lectureTitre.textContent = messageLu.dataset.titre;
        lectureExpediteur.textContent = messageLu.dataset.expediteur;
        lectureContenu.textContent = messageLu.dataset.contenu;
        lectureDate.textContent = messageLu.dataset.envoyeLe;
        modaleLectureMessage.classList.remove("modale-cachee");
        modaleLectureMessage.classList.add("modale-visible");
        if (messageLu.dataset.lu === "0") {
            const donnees = new FormData();
            donnees.append("action", "marquerLu");
            donnees.append("messageId", messageLu.dataset.id);
            donnees.append("jetonCsrf", jetonCsrf);

            fetch("?page=messages", { method: "POST", body: donnees })
                .then(function (reponse) {
                    return reponse.json();
                })
                .then(function (resultat) {
                    if (resultat.succes === true) {
                        messageLu.dataset.lu = "1";
                        messageLu.closest("tr").querySelector(".etat-message").textContent = "Message lu";
                    }
                })
                .catch(function () {});
        };
    })
};


// Fermeture modale de lecture de message
if (fermerLectureMessage) {
    fermerLectureMessage.addEventListener("click", function(){
        modaleLectureMessage.classList.remove("modale-visible");
        modaleLectureMessage.classList.add("modale-cachee");
    });
};
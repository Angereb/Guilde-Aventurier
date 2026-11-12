// Constante des boutons récupérés
const boutonOuvrir = document.getElementById("ouvrirAnnonce");
const boutonCreationFermer = document.getElementById("fermerCreationAnnonce");
const boutonLectureFermer = document.getElementById("fermerLectureAnnonce");
const boutonModificationOuvrir = document.getElementById("ouvrirModificationAnnonce");
const boutonfermerModificationAnnonce = document.getElementById("fermerModificationAnnonce");
const boutonSuppressionOuvrir = document.getElementById("ouvrirSuppressionAnnonce");
const boutonfermerSuppressionAnnonce = document.getElementById("fermerSuppressionAnnonce");

// Constante des modales
const modaleCreation = document.getElementById("modaleAnnonce");
const modaleLecture  = document.getElementById("modaleLecture");
const modaleModificationAnnonce = document.getElementById("modaleModificationAnnonce");
const modaleSuppressionAnnonce = document.getElementById("modaleSuppressionAnnonce");

// Constante du contenu de lecture
const lectureTitre = document.getElementById("lectureTitre");
const lectureDate = document.getElementById("lectureDate");
const lectureAuteur = document.getElementById("lectureAuteur");
const lectureContenu = document.getElementById("lectureContenu");

// Constante des documents récupérés
const annonces = document.querySelectorAll(".annonce-recuperer");

// Constante de pré-remplissage pour le formulaire de modification
const idCibleModifier = document.getElementById("idCibleModifier");

// Constante de pré-remplissage pour le formulaire de suppression
const idCibleSupprimer = document.getElementById("idCibleSupprimer");

// Constante des formulaires
const formulaireAnnonce = document.getElementById("formulaireAnnonce");
const formulaireModifierAnnonce = document.getElementById("formulaireModifierAnnonce");

// Constante des inputs à vérifier
const titreInput = document.getElementById("titreInput");
const texteInput = document.getElementById("texteInput");
const titreModifierInput = document.getElementById("titreModifierInput");
const texteModifierInput = document.getElementById("texteModifierInput");


// Ouverture modale de création d'annonce
if (boutonOuvrir) {
    boutonOuvrir.addEventListener("click", function(event){
        modaleCreation.classList.remove("modale-cachee");
        modaleCreation.classList.add("modale-visible");
    });
}    

// Fermeture de modale de création d'annonce
if (boutonCreationFermer) {
    boutonCreationFermer.addEventListener("click", function(){
        modaleCreation.classList.remove("modale-visible");
        modaleCreation.classList.add("modale-cachee");
    });
}

// Remplissage des annonces
for (const article of annonces) {
    const boutonLectureOuvrir = article.querySelector(".ouverture-annonce");
    if (boutonLectureOuvrir) {
        boutonLectureOuvrir.addEventListener("click", function(){
            lectureTitre.textContent = article.dataset.titre;
            lectureDate.textContent = article.dataset.date;
            lectureAuteur.textContent = article.dataset.auteur;
            lectureContenu.textContent = article.dataset.contenu;
            idCibleModifier.value = article.dataset.id;
            titreModifierInput.value = article.dataset.titre;
            texteModifierInput.value = article.dataset.contenu;
            idCibleSupprimer.value = article.dataset.id;
            modaleLecture.classList.remove("modale-cachee");
            modaleLecture.classList.add("modale-visible");
        });
    }
}

// Fermeture modale de lecture d'annonce
if (boutonLectureFermer) {
    boutonLectureFermer.addEventListener("click", function(){
        modaleLecture.classList.remove("modale-visible");
        modaleLecture.classList.add("modale-cachee");
    });
}

// Ouverture modale de modification d'annonce + cache de la lecture
if (boutonModificationOuvrir) {
    boutonModificationOuvrir.addEventListener("click", function(){
        modaleModificationAnnonce.classList.remove("modale-cachee");
        modaleModificationAnnonce.classList.add("modale-visible");
        modaleLecture.classList.remove("modale-visible");
        modaleLecture.classList.add("modale-cachee");
    });
}    

// Fermeture de modale de modification d'annonce + ré-apparition de la lecture
if (boutonfermerModificationAnnonce) {
    boutonfermerModificationAnnonce.addEventListener("click", function(){
        modaleModificationAnnonce.classList.remove("modale-visible");
        modaleModificationAnnonce.classList.add("modale-cachee");
        modaleLecture.classList.remove("modale-cachee");
        modaleLecture.classList.add("modale-visible");
    });
}

// Ouverture modale de suppression d'annonce + cache de la lecture
if (boutonSuppressionOuvrir) {
    boutonSuppressionOuvrir.addEventListener("click", function(){
        modaleSuppressionAnnonce.classList.remove("modale-cachee");
        modaleSuppressionAnnonce.classList.add("modale-visible");
        boutonfermerSuppressionAnnonce.focus();
        modaleLecture.classList.remove("modale-visible");
        modaleLecture.classList.add("modale-cachee");
    });
}    

// Fermeture de modale de suppression d'annonce + ré-apparition de la lecture
if (boutonfermerSuppressionAnnonce ) {
    boutonfermerSuppressionAnnonce .addEventListener("click", function(){
        modaleSuppressionAnnonce.classList.remove("modale-visible");
        modaleSuppressionAnnonce.classList.add("modale-cachee");
        modaleLecture.classList.remove("modale-cachee");
        modaleLecture.classList.add("modale-visible");
    });
}

// Validation des entrées dans le formulaire de création d'annonce
function verifierTitre() {
    const titreInputTrim = titreInput.value.trim();
    if (titreInputTrim === "") {
        afficherErreur(titreInput, "L'annonce doit avoir un titre.");
        return false;
    }
    if (titreInputTrim.length > 128) {
        afficherErreur(titreInput, "Le titre de l'annonce ne peut excéder 128 caractères.");
        return false;
    }
    effacerErreur(titreInput);
    return true
}

function verifierTexte() {
    const texteInputTrim = texteInput.value.trim();
    if (texteInputTrim === "") {
        afficherErreur(texteInput, "L'annonce doit avoir un contenu.");
        return false;
    }
    if (texteInputTrim.length > 2500) {
        afficherErreur(texteInput, "Le contenu de l'annonce ne doit pas dépasser 2500 caractères.");
        return false;
    }
    effacerErreur(texteInput);
    return true;
}

titreInput.addEventListener("blur", verifierTitre);

texteInput.addEventListener("blur", verifierTexte);

formulaireAnnonce.addEventListener("submit", function(event) {
    let formulaireAnnonceValide = true;
    if (!verifierTitre()) {
        formulaireAnnonceValide = false;
    }
    if (!verifierTexte()) {
        formulaireAnnonceValide = false;
    }
    if (formulaireAnnonceValide === false) {
        event.preventDefault();
    }
})

// Validation des entrées dans le formulaire de modification d'annonce
function verifierTitreModifier() {
    const titreModifierInputTrim = titreModifierInput.value.trim();
    if (titreModifierInputTrim === "") {
        afficherErreur(titreModifierInput, "L'annonce doit avoir un titre.");
        return false;
    }
    if (titreModifierInputTrim.length > 128) {
        afficherErreur(titreModifierInput, "Le titre de l'annonce ne peut excéder 128 caractères.");
        return false;
    }
    effacerErreur(titreModifierInput);
    return true
}

function verifierTexteModifier() {
    const texteModifierInputTrim = texteModifierInput.value.trim();
    if (texteModifierInputTrim === "") {
        afficherErreur(texteModifierInput, "L'annonce doit avoir un contenu.");
        return false;
    }
    if (texteModifierInputTrim.length > 2500) {
        afficherErreur(texteModifierInput, "Le contenu de l'annonce ne doit pas dépasser 2500 caractères.");
        return false;
    }
    effacerErreur(texteModifierInput);
    return true;
}

titreModifierInput.addEventListener("blur", verifierTitreModifier);

texteModifierInput.addEventListener("blur", verifierTexteModifier);

formulaireModifierAnnonce.addEventListener("submit", function(event) {
    let formulaireAnnonceModifierValide = true;
    if (!verifierTitreModifier()) {
        formulaireAnnonceModifierValide = false;
    }
    if (!verifierTexteModifier()) {
        formulaireAnnonceModifierValide = false;
    }
    if (formulaireAnnonceModifierValide === false) {
        event.preventDefault();
    }
})
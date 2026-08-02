const boutonOuvrir = document.getElementById("ouvrirAnnonce");
const boutonCreationFermer = document.getElementById("fermerCreationAnnonce");

const boutonLectureFermer = document.getElementById("fermerLectureAnnonce");

const modaleCreation = document.getElementById("modaleAnnonce");
const modaleLecture  = document.getElementById("modaleLecture");

const lectureTitre = document.getElementById("lectureTitre");
const lectureDate = document.getElementById("lectureDate");
const lectureAuteur = document.getElementById("lectureAuteur");
const lectureContenu = document.getElementById("lectureContenu");

const annonces = document.querySelectorAll(".annonce-recuperer");

const modaleModificationAnnonce = document.getElementById("modaleModificationAnnonce");
const boutonModificationOuvrir = document.getElementById("ouvrirModificationAnnonce");
const idCibleModifier = document.getElementById("idCibleModifier");
const titreModifierInput = document.getElementById("titreModifierInput");
const texteModifierInput = document.getElementById("texteModifierInput");
const fermerModificationAnnonce = document.getElementById("fermerModificationAnnonce");

const modaleSuppressionAnnonce = document.getElementById("modaleSuppressionAnnonce");
const boutonSuppressionOuvrir = document.getElementById("ouvrirSuppressionAnnonce");
const idCibleSupprimer = document.getElementById("idCibleSupprimer");
const fermerSuppressionAnnonce = document.getElementById("fermerSuppressionAnnonce");

if (boutonOuvrir) {
    boutonOuvrir.addEventListener("click", function(event){
        event.preventDefault();

        modaleCreation.classList.remove("modale-cachee");
        modaleCreation.classList.add("modale-visible");
    });
}    

if (boutonCreationFermer) {
    boutonCreationFermer.addEventListener("click", function(){
        modaleCreation.classList.remove("modale-visible");
        modaleCreation.classList.add("modale-cachee");
    });
}

for (const article of annonces) {
    article.addEventListener("click", function(event){
        event.preventDefault();

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

if (boutonLectureFermer) {
    boutonLectureFermer.addEventListener("click", function(){
        modaleLecture.classList.remove("modale-visible");
        modaleLecture.classList.add("modale-cachee");
    });
}

if (boutonModificationOuvrir) {
    boutonModificationOuvrir.addEventListener("click", function(event){
        event.preventDefault();

        modaleModificationAnnonce.classList.remove("modale-cachee");
        modaleModificationAnnonce.classList.add("modale-visible");

        modaleLecture.classList.remove("modale-visible");
        modaleLecture.classList.add("modale-cachee");
    });
}    

if (fermerModificationAnnonce) {
    fermerModificationAnnonce.addEventListener("click", function(){
        modaleModificationAnnonce.classList.remove("modale-visible");
        modaleModificationAnnonce.classList.add("modale-cachee");

        modaleLecture.classList.remove("modale-cachee");
        modaleLecture.classList.add("modale-visible");
    });
}

if (boutonSuppressionOuvrir) {
    boutonSuppressionOuvrir.addEventListener("click", function(event){
        event.preventDefault();

        modaleSuppressionAnnonce.classList.remove("modale-cachee");
        modaleSuppressionAnnonce.classList.add("modale-visible");

        modaleLecture.classList.remove("modale-visible");
        modaleLecture.classList.add("modale-cachee");
    });
}    

if (fermerSuppressionAnnonce ) {
    fermerSuppressionAnnonce .addEventListener("click", function(){
        modaleSuppressionAnnonce.classList.remove("modale-visible");
        modaleSuppressionAnnonce.classList.add("modale-cachee");

        modaleLecture.classList.remove("modale-cachee");
        modaleLecture.classList.add("modale-visible");
    });
}
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
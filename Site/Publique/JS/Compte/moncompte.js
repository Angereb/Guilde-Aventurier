const boutonModifPseudoOuvrir = document.getElementById("modifierPseudo");
const modalePseudo = document.getElementById("modalePseudo");
const boutonModifPseudoFermer = document.getElementById("fermerModifierPseudo");

const boutonModifEmailOuvrir = document.getElementById("modifierEmail");
const modaleEmail = document.getElementById("modaleEmail");
const boutonModifEmailFermer = document.getElementById("fermerModifierEmail");

const boutonModifMotDePasseOuvrir = document.getElementById("modifierMotDePasse");
const modaleMotDePasse = document.getElementById("modaleMotDePasse");
const boutonModifMotDePasseFermer = document.getElementById("fermerModifierMotDePasse");

const boutonSupprimerCompteOuvrir = document.getElementById("supprimerCompte");
const modaleSupprimerCompte = document.getElementById("modaleSupprimerCompte");
const boutonSupprimerCompteFermer = document.getElementById("fermerSupprimerCompte");

if (boutonModifPseudoOuvrir) {
    boutonModifPseudoOuvrir.addEventListener("click", function(event){
        event.preventDefault();

        modalePseudo.classList.remove("modale-cachee");
        modalePseudo.classList.add("modale-visible");
    });
}    

if (boutonModifPseudoFermer) {
    boutonModifPseudoFermer.addEventListener("click", function(){
        modalePseudo.classList.remove("modale-visible");
        modalePseudo.classList.add("modale-cachee");
    });
}

if (boutonModifEmailOuvrir) {
    boutonModifEmailOuvrir.addEventListener("click", function(event){
        event.preventDefault();

        modaleEmail.classList.remove("modale-cachee");
        modaleEmail.classList.add("modale-visible");
    });
}    

if (boutonModifEmailFermer) {
    boutonModifEmailFermer.addEventListener("click", function(){
        modaleEmail.classList.remove("modale-visible");
        modaleEmail.classList.add("modale-cachee");
    });
}

if (boutonModifMotDePasseOuvrir) {
    boutonModifMotDePasseOuvrir.addEventListener("click", function(event){
        event.preventDefault();

        modaleMotDePasse.classList.remove("modale-cachee");
        modaleMotDePasse.classList.add("modale-visible");
    });
}    

if (boutonModifMotDePasseFermer) {
    boutonModifMotDePasseFermer.addEventListener("click", function(){
        modaleMotDePasse.classList.remove("modale-visible");
        modaleMotDePasse.classList.add("modale-cachee");
    });
}

if (boutonSupprimerCompteOuvrir) {
    boutonSupprimerCompteOuvrir.addEventListener("click", function(event){
        event.preventDefault();

        modaleSupprimerCompte.classList.remove("modale-cachee");
        modaleSupprimerCompte.classList.add("modale-visible");
    });
} 

if (boutonSupprimerCompteFermer) {
    boutonSupprimerCompteFermer.addEventListener("click", function(){
        modaleSupprimerCompte.classList.remove("modale-visible");
        modaleSupprimerCompte.classList.add("modale-cachee");
    });
}
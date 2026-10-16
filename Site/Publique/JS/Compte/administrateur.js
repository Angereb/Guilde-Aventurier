// Constante des boutons récupérés
const boutonAdminFermer = document.getElementById("fermerModaleAdmin");

// Constante des modales
const modaleAdmin = document.getElementById("modaleAdmin");

// Constante de sélection des utilisateurs
const utilisateursCible = document.querySelectorAll(".utilisateur-recuperer");

// Constante des données
const idCibleRoles = document.getElementById("idCibleRoles");
const idCibleBlocage = document.getElementById("idCibleBlocage");

// Constante des checkbox
const checkboxAdmin = document.getElementById("checkboxAdmin");
const checkboxActif = document.getElementById("checkboxActif");

// Constante des formulaires 
const formulaireRecherche = document.getElementById("formulaireRecherche");

// Constante des inputs à vérifier
const rechercherInput = document.getElementById("rechercherInput");

// Validation de l'entrée dans le formulaire de recherche
formulaireRecherche.addEventListener("submit", function(event) {
    const rechercherInputTrim = rechercherInput.value.trim();
    let formulaireRechercheValide = true;
    if (rechercherInputTrim === "") {
        afficherErreur(rechercherInput, "La recherche ne peut être vide.");
        formulaireRechercheValide = false;
    } else {
        effacerErreur(rechercherInput);
    }
    if (formulaireRechercheValide === false) {
        event.preventDefault();
    }
});

// Remplissage et ouverture de la modale de modération
for (const utilisateur of utilisateursCible) {
    const boutonUtilisateur = utilisateur.querySelector(".ouverture-modification-statut");
    boutonUtilisateur.addEventListener("click", function() {
        // 1. Remplir les deux champs cachés avec l'id de l'utilisateur cliqué
        idCibleRoles.value = utilisateur.dataset.id;
        idCibleBlocage.value = utilisateur.dataset.id;

        // 2. Précocher la checkbox admin si le rôle est présent dans data-roles
        const roles = utilisateur.dataset.roles.split(", ");
        checkboxAdmin.checked = roles.includes("ROLE_ADMINISTRATEUR");

        // 3. Précocher la checkbox actif selon la donnée (qui vaut "0" ou "1")
        checkboxActif.checked = utilisateur.dataset.actif === "0";

        // 4. Afficher la modale
        modaleAdmin.classList.remove("modale-cachee");
        modaleAdmin.classList.add("modale-visible");
    });
}

// Fermeture de la modale de modération
if (boutonAdminFermer) {
    boutonAdminFermer.addEventListener("click", function(){
        modaleAdmin.classList.remove("modale-visible");
        modaleAdmin.classList.add("modale-cachee");
    });
}
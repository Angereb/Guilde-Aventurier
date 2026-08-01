const utilisateursCible = document.querySelectorAll(".utilisateur-recuperer");
const modaleAdmin = document.getElementById("modaleAdmin");

const idCibleRoles = document.getElementById("idCibleRoles");
const idCibleBlocage = document.getElementById("idCibleBlocage");
const checkboxAdmin = document.getElementById("checkboxAdmin");
const checkboxEstSupprimer = document.getElementById("checkboxEstSupprimer");

const boutonAdminFermer = document.getElementById("fermerModaleAdmin");

for (const utilisateur of utilisateursCible) {
    utilisateur.addEventListener("click", function(event) {
        // 1. Remplir les deux champs cachés avec l'id de l'utilisateur cliqué
        idCibleRoles.value = utilisateur.dataset.id;
        idCibleBlocage.value = utilisateur.dataset.id;

        // 2. Précocher la checkbox admin si le rôle est présent dans data-roles
        const roles = utilisateur.dataset.roles.split(", ");
        checkboxAdmin.checked = roles.includes("ROLE_ADMINISTRATEUR");

        // 3. Précocher la checkbox estSupprimer selon la donnée (qui vaut "0" ou "1")
        checkboxEstSupprimer.checked = utilisateur.dataset.estSupprimer === "1";

        // 4. Afficher la modale
        modaleAdmin.classList.remove("modale-cachee");
        modaleAdmin.classList.add("modale-visible");
    });
}

if (boutonAdminFermer) {
    boutonAdminFermer.addEventListener("click", function(){
        modaleAdmin.classList.remove("modale-visible");
        modaleAdmin.classList.add("modale-cachee");
    });
}
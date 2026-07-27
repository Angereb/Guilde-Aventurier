<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

$titre = "Connexion";

$css = [
    "style.css",
    "Secretariat/connexion.css",
    "Composants/entete.css"
];

$javascript = [];

$messageErreur = null;

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $identifiant= $_POST["identifiant"];
    $motDePasse= $_POST["motDePasse"];

    try{
        $utilisateurModele = new UtilisateurModele();
        
        //Recherche d'un utilisateur correspondant soit à l'Email soit au Pseudo
        if (filter_var($identifiant, FILTER_VALIDATE_EMAIL)) {
            $utilisateur = $utilisateurModele->rechercherParEmail($identifiant);
        }
        else {
            $utilisateur = $utilisateurModele->rechercherParPseudo($identifiant);
        }

        //Vérification de l'état du compte
        if ($utilisateur->getEstSupprimer()) {
            throw new Exception("Ce compte n'est plus actif, veuillez contacter un administrateur.");
        }

        //Camparaison du mot de passe saisie avec la version hashé récupérer
        if (!password_verify($motDePasse, $utilisateur->getMotDePasse())) {
            throw new Exception("Identifiant ou mot de passe incorrect.");
        }

        //Si tout est OK ouverture de session
        $_SESSION["utilisateur"] = ["id" => $utilisateur->getId(),"uuid" => $utilisateur->getUuid(),"pseudo" => $utilisateur->getPseudo(),"roles" => $utilisateur->getRoles()];

        //Redirection vers le hall
        header("Location: ?page=hall");
        exit;
    }

    catch(Exception $e){$messageErreur = $e->getMessage();}    
}

ob_start();

require __DIR__ . '/../../Vus/Secretariat/connexion.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>
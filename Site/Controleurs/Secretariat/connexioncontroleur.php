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
    $email= $_POST["email"];
    $motDePasse= $_POST["motDePasse"];

    try{
        $utilisateurModele = new UtilisateurModele();
        
        //Recherche d'un utilisateur correspondant à l'adresse mail
        $utilisateur = $utilisateurModele->rechercherParEmail($email);

        //Camparaison du mot de passe saisie avec la version hashé récupérer
        if (!password_verify($motDePasse, $utilisateur->getMotDePasse())) {
            throw new Exception("Adresse mail ou mot de passe incorrect.");
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
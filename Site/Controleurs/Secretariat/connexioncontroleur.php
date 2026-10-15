<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

if (isset($_SESSION["utilisateur"])) {
    header("Location: ?page=hall");
    exit;
}

$titre = "Connexion";

$css = ["Secretariat/connexion.css"];

$javascript = ["Secretariat/formulaireconnexion.js"];

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $originePage = $_POST["origine"] ?? "";
    $identifiant= $_POST["identifiant"] ?? "";
    $motDePasse= $_POST["motDePasse"] ?? "";

    try{
        if (!in_array($originePage, ["connexion", "inscriptionetconnexion"], true)) {
            $originePage = "connexion";
        }

        // Vérification du jeton CSRF avec hash_equals pour éviter que les hackers comprennent où le jeton est faux
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }

        $utilisateurModele = new UtilisateurModele();
        
        //Recherche d'un utilisateur correspondant soit à l'Email soit au Pseudo
        try {
            if (filter_var($identifiant, FILTER_VALIDATE_EMAIL)) {
                $utilisateur = $utilisateurModele->rechercherParEmail($identifiant);
            } else {
                $utilisateur = $utilisateurModele->rechercherParPseudo($identifiant);
            }
        } catch (Exception $e) {
            throw new Exception("Identifiant ou mot de passe incorrect.");
        }

        //Comparaison du mot de passe saisi avec la version hachée récupérée
        if (!password_verify($motDePasse, $utilisateur->getMotDePasse())) {
            throw new Exception("Identifiant ou mot de passe incorrect.");
        }

        //Vérification de l'état du compte
        if ($utilisateur->getEstSupprime()) {
            throw new Exception("Identifiant ou mot de passe incorrect.");
        }
        if ($utilisateur->getActif() !== true) {
            throw new Exception("Ce compte a été bloqué, veuillez contacter un administrateur.");
        }

        //Si tout est OK ouverture de session
        session_regenerate_id(true);
        $_SESSION["utilisateur"] = ["id" => $utilisateur->getUtilisateurId(),"uuid" => $utilisateur->getUuid(),"pseudo" => $utilisateur->getPseudo(),"roles" => $utilisateur->getRoles()];

        //Notification de la réussite
        $_SESSION["notificationMessage"] = "Bienvenue " . $utilisateur->getPseudo() . " !";
        $_SESSION["typeNotification"] = "succes";

        //Redirection vers le hall
        header("Location: ?page=hall");
        exit;
    }

    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=" . $originePage);
        exit;
        }  
}

ob_start();

require __DIR__ . '/../../Vus/Secretariat/connexion.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>
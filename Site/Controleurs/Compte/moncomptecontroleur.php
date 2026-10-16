<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "Mon compte";

$css = [
    "Compte/moncompte.css",
];

$javascript = [
    "Compte/moncompte.js"
];

$utilisateurModele = new UtilisateurModele();

$utilisateur = $utilisateurModele->rechercherParId($_SESSION["utilisateur"]["id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;
    $verificationMotDePasse = $_POST["verificationMotDePasse"] ?? "";
    try{
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
        switch($formulaire){
            case 'modifierGeneral':
                $pseudo = $_POST["pseudo"] ?? "";
                $email = $_POST["email"] ?? "";
                $nomDeCompagnie = $_POST["nomDeCompagnie"] ?? "";
                if (!password_verify($verificationMotDePasse, $utilisateur->getMotDePasse())) {
                    throw new Exception("Mot de passe incorrect.");
                }
                $utilisateur->setPseudo($pseudo);
                $utilisateur->setNomCompagnie($nomDeCompagnie);
                $utilisateur->setEmail($email);
                $utilisateurModele->modifier($utilisateur);
                $_SESSION["utilisateur"]["pseudo"] = $utilisateur->getPseudo();
                $_SESSION["notificationMessage"] = "Votre compte a bien été modifié.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'modifierMotDePasse':
                $nouveauMotDePasse = $_POST["motDePasse"] ?? "";
                $verificationNouveauMotDePasse = $_POST["verificationNouveauMotDePasse"] ?? "";
                if ($nouveauMotDePasse !== $verificationNouveauMotDePasse) {
                    throw new Exception("Les deux mots de passe ne correspondent pas.");
                }
                if (!password_verify($verificationMotDePasse, $utilisateur->getMotDePasse())) {
                    throw new Exception("Ancien mot de passe incorrect.");
                }
                $utilisateur->setMotDePasse($nouveauMotDePasse);
                $utilisateurModele->modifierMotDePasse($utilisateur);
                session_regenerate_id(true);
                $_SESSION["notificationMessage"] = "Votre mot de passe a bien été modifié.";
                $_SESSION["typeNotification"] = "succes";
                break;

            case 'supprimerCompte':
                if (!password_verify($verificationMotDePasse, $utilisateur->getMotDePasse())) {
                    throw new Exception("Mot de passe incorrect.");
                }
                $utilisateurModele->anonymiser($utilisateur->getUtilisateurId());
                $_SESSION = [];
                $parametres = session_get_cookie_params();
                setcookie(session_name(), "", [
                    "expires" => time() - 3600,
                    "path" => $parametres["path"],
                    "domain" => $parametres["domain"],
                    "secure" => $parametres["secure"],
                    "httponly" => $parametres["httponly"],
                    "samesite" => $parametres["samesite"],
                ]);
                session_destroy();
                header("Location: ?page=entree");
                exit;

            default:
                throw new Exception("Action inconnue.");
        }
        header("Location: ?page=moncompte");
        exit;
    }

    catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
        header("Location: ?page=moncompte");
        exit;
    } 
}

ob_start();

require __DIR__ . '/../../Vus/Compte/moncompte.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';
?>
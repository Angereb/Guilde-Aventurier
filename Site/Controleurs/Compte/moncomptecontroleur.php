<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

if (!isset($_SESSION["utilisateur"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "moncompte";

$css = [
    "style.css",
    "Composants/entete.css",
    "Compte/moncompte.css"
];

$javascript = [
    "Compte/moncompte.js"
];

$messageErreur = null;

$utilisateurModele = new UtilisateurModele();

$utilisateur = $utilisateurModele->rechercherParId($_SESSION["utilisateur"]["id"]);

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;
    $verificationMotDePasse = $_POST["verificationMotDePasse"] ?? null;

    try{
        switch($formulaire){
            case 'modifierPseudo':
                $pseudo = $_POST["pseudo"];

                if (!password_verify($verificationMotDePasse, $utilisateur->getMotDePasse())) {
                    throw new Exception("Mot de passe incorrect.");
                }

                $utilisateur->setPseudo($pseudo);
                $utilisateurModele->modifierPseudo($utilisateur);
                $_SESSION["utilisateur"]["pseudo"] = $utilisateur->getPseudo();
                break;

            case 'modifierNomDeCompagnie':
                $nomDeCompagnie = $_POST["nomDeCompagnie"];
                $utilisateur->setNomDeCompagnie($nomDeCompagnie);
                $utilisateurModele->modifierNomDeCompagnie($utilisateur);
                break;

            case 'modifierEmail':
                $email = $_POST["email"];

                if (!password_verify($verificationMotDePasse, $utilisateur->getMotDePasse())) {
                    throw new Exception("Mot de passe incorrect.");
                }

                $utilisateur->setEmail($email);
                $utilisateurModele->modifierEmail($utilisateur);
                break;

            case 'modifierMotDePasse':
                $motDePasse = $_POST["motDePasse"];

                if (!password_verify($verificationMotDePasse, $utilisateur->getMotDePasse())) {
                    throw new Exception("Ancien mot de passe incorrect.");
                }

                $utilisateur->setMotDePasse($motDePasse);
                $utilisateurModele->modifierMotDePasse($utilisateur);
                break;

            case 'supprimerCompte':
                if (!password_verify($verificationMotDePasse, $utilisateur->getMotDePasse())) {
                    throw new Exception("Ancien mot de passe incorrect.");
                }

                $utilisateur->setEstSupprimer(true);
                $utilisateurModele->modifierEstSupprimer($utilisateur);

                $_SESSION = [];

                session_destroy();

                header("Location: ?page=entree");
                exit;

            default:
                throw new Exception("Action inconnue.");
        }
        header("Location: ?page=moncompte");
        exit;
    }

    catch(Exception $e){$messageErreur = $e->getMessage();} 
}

ob_start();

require __DIR__ . '/../../Vus/Compte/moncompte.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';
?>
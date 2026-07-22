<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

$titre = "Inscription";

$css = [
    "style.css",
    "Secretariat/inscription.css",
    "Composants/entete.css"
];

$javascript = [];

$messageErreur = null;

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    // Traiter le formulaire
    $id= null;
    $uuid= null;
    $pseudo= $_POST["pseudo"];
    $nomDeCompagnie= $_POST["nomDeCompagnie"];
    $email= $_POST["email"];
    $motDePasse= $_POST["motDePasse"];
    $verificationMotDePasse= $_POST["verificationMotDePasse"];

    try{
        //Vérification du double mot de passe dans le formulaire
        if ($motDePasse !== $verificationMotDePasse) {
            throw new Exception("Les deux mots de passe ne correspondent pas.");
        }
        // Création du livre correspondant
        $utilisateur = new Utilisateur(
            $id,
            $uuid,
            $pseudo,
            $nomDeCompagnie,
            $email,
            $motDePasse,
            [Utilisateur::ROLE_UTILISATEUR],
            null,
            null
        );

        $utilisateurModele = new UtilisateurModele();

        $utilisateurModele->ajouter($utilisateur);

        //Redirection vers la page connexion et sortie de la méthode POST
        header("Location: ?page=connexion");
        exit;
    }

    catch(Exception $e){$messageErreur = $e->getMessage();}
}

ob_start();

require __DIR__ . '/../../Vus/Secretariat/inscription.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>
<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

if (isset($_SESSION["utilisateur"])) {
    header("Location: ?page=hall");
    exit;
}

$titre = "Inscription";

$css = ["Secretariat/inscription.css",];

$javascript = ["Secretariat/formulaireinscription.js"];

$messageErreurInscription = null;

$messageErreurInscription = $_SESSION["messageErreurInscription"] ?? null;
unset($_SESSION["messageErreurInscription"]);

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    // Traiter le formulaire
    $originePage = $_POST["origine"] ?? "";
    $id= null;
    $uuid= null;
    $pseudo= $_POST["pseudo"] ?? "";
    $nomDeCompagnie= $_POST["nomDeCompagnie"] ?? "";
    $email= $_POST["email"] ?? "";
    $motDePasse= $_POST["motDePasse"] ?? "";
    $verificationMotDePasse= $_POST["verificationMotDePasse"] ?? "";

    try{
        if (!in_array($originePage, ["inscription", "inscriptionetconnexion"], true)) {
            $originePage = "inscription";
        }

        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
        
        //Vérification du double mot de passe dans le formulaire
        if ($motDePasse !== $verificationMotDePasse) {
            throw new Exception("Les deux mots de passe ne correspondent pas.");
        }
        // Création de l'utilisateur correspondant
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

        //Redirection vers la page connexion ou la double page inscription/connexion et sortie de la méthode POST
        if ($originePage === "inscription") {
            header("Location: ?page=connexion");
        } else {
            header("Location: ?page=inscriptionetconnexion");
        }
        exit;
    }

    catch(Exception $e){
        $_SESSION["messageErreurInscription"] = $e->getMessage();
        header("Location: ?page=" . $originePage);
        exit;
        }
}

ob_start();

require __DIR__ . '/../../Vus/Secretariat/inscription.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';

?>
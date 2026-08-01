<?php
require_once __DIR__ . "/../../Modeles/Utilisateurs/Utilisateur.php";
require_once __DIR__ . "/../../Modeles/Utilisateurs/UtilisateurModele.php";

if (!isset($_SESSION["utilisateur"]) || !in_array(Utilisateur::ROLE_ADMINISTRATEUR, $_SESSION["utilisateur"]["roles"])) {
    header("Location: ?page=entree");
    exit;
}

$titre = "administrateur";

$css = [
    "style.css",
    "Composants/entete.css",
    "Compte/administrateur.css"
];

$javascript = [
    "Compte/administrateur.js"
];

$messageErreur = null;

$utilisateurModele = new UtilisateurModele();

$utilisateurs = [];

if (isset($_SESSION["rechercheAdmin"])){
    try{
        $trouver= false;
        if ($trouver === false && filter_var($_SESSION["rechercheAdmin"], FILTER_VALIDATE_EMAIL)) {   
            try{
                $utilisateurs[] = $utilisateurModele->rechercherParEmail($_SESSION["rechercheAdmin"]);
                $trouver= true;
            }
            catch(Exception $e){}
        }

        if ($trouver === false){
            try{
                $utilisateurs[] = $utilisateurModele->rechercherParPseudo($_SESSION["rechercheAdmin"]);
                $trouver= true;
            }
            catch(Exception $e){}
        }

        if ($trouver === false) {
            try{
                $utilisateurs = $utilisateurModele->rechercherToutesCompagnies($_SESSION["rechercheAdmin"]);
                $trouver= true;
            }
            catch(Exception $e){}
        }

        if ($trouver === false) {
            throw new Exception("Aucun résultat de la recherche n\'a pu être trouver.");
        }
    }
    catch(Exception $e){$messageErreur = $e->getMessage();}
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    $formulaire = $_POST['action'] ?? null;

    try{
        switch($formulaire){
            case 'rechercherUtilisateur':
                $recherche = $_POST["recherche"];
                $_SESSION["rechercheAdmin"] = $recherche;
                break;
    
            case 'modifierEstSupprimer' :
                $id = (int) $_POST["idCible"];

                if ($id === $_SESSION["utilisateur"]["id"]){
                    throw new Exception("Vous ne pouvez effectuer ce genre de modification sur ce compte.");
                }

                $utilisateur = $utilisateurModele->rechercherParId($id);

                if (isset($_POST["estSupprimer"])){$estSupprimer = true;}
                else {$estSupprimer = false;}

                $utilisateur->setEstSupprimer($estSupprimer);
                $utilisateurModele->modifierEstSupprimer($utilisateur);
                break;

            case 'modifierRoles' :
                $id = (int) $_POST["idCible"];

                if ($id === $_SESSION["utilisateur"]["id"]){
                    throw new Exception("Vous ne pouvez effectuer ce genre de modification sur ce compte.");
                }

                $utilisateur = $utilisateurModele->rechercherParId($id);

                $roles = $_POST["roles"] ?? [];

                $utilisateur->setRoles($roles);
                $utilisateurModele->modifierRoles($utilisateur);
                break;

            default:
                throw new Exception("Action inconnue.");
        }
        header("Location: ?page=administrateur");
        exit;
    }
    catch(Exception $e){$messageErreur = $e->getMessage();} 
}

ob_start();

require __DIR__ . '/../../Vus/Compte/administrateur.php';

$contenu = ob_get_clean();

require __DIR__ . '/../../Vus/calqueprincipale.php';
?>
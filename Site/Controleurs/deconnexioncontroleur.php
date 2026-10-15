<?php
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    try{
        if (!hash_equals($_SESSION["jetonCsrf"] ?? "", $_POST["jetonCsrf"] ?? "")) {
            throw new Exception("Le formulaire n'est pas valide. Veuillez réessayer.");
        }
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
    } catch(Exception $e){
        $_SESSION["notificationMessage"] = $e->getMessage();
        $_SESSION["typeNotification"] = "erreur";
    }
}
header("Location: ?page=hall");
exit;
?>
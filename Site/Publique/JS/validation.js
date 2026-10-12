function afficherErreur(champ, message) {
    const idMessage = champ.getAttribute("aria-describedby");
    const zoneMessage = document.getElementById(idMessage);
    zoneMessage.textContent = message;
    champ.setAttribute("aria-invalid", "true");
}

function effacerErreur(champ) {
    const idMessage = champ.getAttribute("aria-describedby");
    const zoneMessage = document.getElementById(idMessage);
    zoneMessage.textContent = "";
    champ.removeAttribute("aria-invalid");
}
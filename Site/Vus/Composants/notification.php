<?php if (isset($notificationMessage, $typeNotification)): ?>
    <div class="notification notification-<?= ($typeNotification) === "succes" ? "succes" : "erreur" ?>" role="<?= ($typeNotification) === "succes" ? "status" : "alert"  ?>">
        <p class="notification-message"><?= htmlspecialchars($notificationMessage) ?></p>
        <button type="button" class="fermer-notification" aria-label="Fermer la notification">x</button>
    </div>
<?php endif; ?>
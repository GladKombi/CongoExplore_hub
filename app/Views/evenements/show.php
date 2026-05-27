<h2><?php echo htmlspecialchars($title); ?></h2>
<?php if (!empty($evenement)): ?>
    <ul>
        <li><strong>ID :</strong> <?php echo $evenement['id']; ?></li>
        <li><strong>Titre :</strong> <?php echo htmlspecialchars($evenement['titre']); ?></li>
        <li><strong>Début :</strong> <?php echo $evenement['date_debut']; ?></li>
        <li><strong>Fin :</strong> <?php echo $evenement['date_fin']; ?></li>
        <li><strong>Lieu :</strong> <?php echo htmlspecialchars($evenement['lieu']); ?></li>
    </ul>
<?php else: ?>
    <div class="empty">Événement introuvable.</div>
<?php endif; ?>

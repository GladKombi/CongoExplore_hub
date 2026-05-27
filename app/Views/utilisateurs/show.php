<h2><?php echo htmlspecialchars($title); ?></h2>
<?php if (!empty($utilisateur)): ?>
    <ul>
        <li><strong>ID :</strong> <?php echo $utilisateur['id']; ?></li>
        <li><strong>Nom :</strong> <?php echo htmlspecialchars($utilisateur['nom']); ?></li>
        <li><strong>Prénom :</strong> <?php echo htmlspecialchars($utilisateur['prenom']); ?></li>
        <li><strong>Email :</strong> <?php echo htmlspecialchars($utilisateur['email']); ?></li>
        <li><strong>Rôle :</strong> <?php echo htmlspecialchars($utilisateur['role']); ?></li>
        <li><strong>Créé le :</strong> <?php echo $utilisateur['date_creation']; ?></li>
    </ul>
<?php else: ?>
    <div class="empty">Utilisateur introuvable.</div>
<?php endif; ?>

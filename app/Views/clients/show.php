<h2><?php echo htmlspecialchars($title); ?></h2>
<?php if (!empty($client)): ?>
    <ul>
        <li><strong>ID :</strong> <?php echo $client['id']; ?></li>
        <li><strong>Entreprise :</strong> <?php echo htmlspecialchars($client['nom_entreprise']); ?></li>
        <li><strong>Email :</strong> <?php echo htmlspecialchars($client['email_contact']); ?></li>
        <li><strong>Téléphone :</strong> <?php echo htmlspecialchars($client['telephone']); ?></li>
        <li><strong>Adresse :</strong> <?php echo htmlspecialchars($client['adresse']); ?></li>
    </ul>
<?php else: ?>
    <div class="empty">Client introuvable.</div>
<?php endif; ?>

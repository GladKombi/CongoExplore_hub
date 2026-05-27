<h2><?php echo htmlspecialchars($title); ?></h2>
<?php if (!empty($contenu)): ?>
    <ul>
        <li><strong>ID :</strong> <?php echo $contenu['id']; ?></li>
        <li><strong>Titre :</strong> <?php echo htmlspecialchars($contenu['titre']); ?></li>
        <li><strong>Statut :</strong> <?php echo htmlspecialchars($contenu['statut']); ?></li>
        <li><strong>Vues :</strong> <?php echo $contenu['vues']; ?></li>
        <li><strong>Catégorie :</strong> <?php echo $contenu['categorie_id']; ?></li>
        <li><strong>Auteur :</strong> <?php echo $contenu['auteur_id']; ?></li>
        <li><strong>Date publication :</strong> <?php echo $contenu['date_publication']; ?></li>
        <li><strong>Corps :</strong> <?php echo nl2br(htmlspecialchars($contenu['corps_text'])); ?></li>
    </ul>
<?php else: ?>
    <div class="empty">Contenu introuvable.</div>
<?php endif; ?>

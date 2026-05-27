<h2><?php echo htmlspecialchars($title); ?></h2>
<?php if (!empty($contenus)): ?>
<table>
    <tr><th>ID</th><th>Titre</th><th>Statut</th><th>Vues</th><th>Date publication</th></tr>
    <?php foreach ($contenus as $contenu): ?>
        <tr>
            <td><?php echo $contenu['id']; ?></td>
            <td><?php echo htmlspecialchars($contenu['titre']); ?></td>
            <td><?php echo htmlspecialchars($contenu['statut']); ?></td>
            <td><?php echo $contenu['vues']; ?></td>
            <td><?php echo $contenu['date_publication']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <div class="empty">Aucun contenu disponible.</div>
<?php endif; ?>

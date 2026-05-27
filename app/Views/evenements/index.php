<h2><?php echo htmlspecialchars($title); ?></h2>
<?php if (!empty($evenements)): ?>
<table>
    <tr><th>ID</th><th>Titre</th><th>Début</th><th>Fin</th><th>Lieu</th></tr>
    <?php foreach ($evenements as $evenement): ?>
        <tr>
            <td><?php echo $evenement['id']; ?></td>
            <td><?php echo htmlspecialchars($evenement['titre']); ?></td>
            <td><?php echo $evenement['date_debut']; ?></td>
            <td><?php echo $evenement['date_fin']; ?></td>
            <td><?php echo htmlspecialchars($evenement['lieu']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <div class="empty">Aucun événement trouvé.</div>
<?php endif; ?>

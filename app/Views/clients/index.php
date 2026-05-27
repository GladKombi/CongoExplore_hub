<h2><?php echo htmlspecialchars($title); ?></h2>
<?php if (!empty($clients)): ?>
<table>
    <tr><th>ID</th><th>Entreprise</th><th>Email</th><th>Téléphone</th></tr>
    <?php foreach ($clients as $client): ?>
        <tr>
            <td><?php echo $client['id']; ?></td>
            <td><?php echo htmlspecialchars($client['nom_entreprise']); ?></td>
            <td><?php echo htmlspecialchars($client['email_contact']); ?></td>
            <td><?php echo htmlspecialchars($client['telephone']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <div class="empty">Aucun client trouvé.</div>
<?php endif; ?>

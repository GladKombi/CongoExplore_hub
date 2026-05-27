<h2><?php echo htmlspecialchars($title); ?></h2>
<?php if (!empty($utilisateurs)): ?>
<table>
    <tr><th>ID</th><th>Nom</th><th>Prénom</th><th>Email</th><th>Role</th></tr>
    <?php foreach ($utilisateurs as $utilisateur): ?>
        <tr>
            <td><?php echo $utilisateur['id']; ?></td>
            <td><?php echo htmlspecialchars($utilisateur['nom']); ?></td>
            <td><?php echo htmlspecialchars($utilisateur['prenom']); ?></td>
            <td><?php echo htmlspecialchars($utilisateur['email']); ?></td>
            <td><?php echo htmlspecialchars($utilisateur['role']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <div class="empty">Aucun utilisateur trouvé.</div>
<?php endif; ?>

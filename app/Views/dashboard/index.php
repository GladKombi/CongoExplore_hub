<?php
$user = $_SESSION['user'] ?? ['prenom' => '', 'nom' => '', 'role' => 'Visiteur'];
$role = $user['role'] ?? 'Visiteur';
$fullName = trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')) ?: 'Utilisateur';
?>

<div class="space-y-6">
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="stat-card bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Bienvenue</p>
                    <h2 class="text-2xl font-bold text-primary-900">Bonjour, <?php echo htmlspecialchars($fullName); ?></h2>
                    <p class="text-sm text-gray-500 mt-2">Vous êtes connecté en tant que <strong><?php echo htmlspecialchars($role); ?></strong>.</p>
                </div>
                <div class="w-14 h-14 rounded-3xl bg-primary-50 flex items-center justify-center text-primary-700 font-bold text-xl uppercase">
                    <?php echo htmlspecialchars(substr($user['prenom'] ?? 'U', 0, 1) . substr($user['nom'] ?? '', 0, 1)); ?>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Utilisateurs</p>
            <p class="text-3xl font-bold text-primary-900">Accès</p>
            <p class="text-sm text-gray-500 mt-2"><?php echo $role === 'Admin' ? 'Accès total à tous les modules.' : 'Accès aux contenus, clients et événements.'; ?></p>
        </div>

        <div class="stat-card bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Action rapide</p>
            <div class="space-y-3">
                <?php if ($role === 'Admin'): ?>
                    <a href="<?php echo BASE_URL; ?>utilisateur" class="block px-4 py-3 rounded-2xl bg-primary-900 text-white text-sm font-medium hover:bg-primary-800 transition">Gérer les utilisateurs</a>
                <?php endif; ?>
                <a href="<?php echo BASE_URL; ?>contenu" class="block px-4 py-3 rounded-2xl bg-gold-500 text-primary-900 text-sm font-medium hover:bg-gold-600 transition">Gérer les contenus</a>
                <a href="<?php echo BASE_URL; ?>evenement" class="block px-4 py-3 rounded-2xl bg-primary-50 text-primary-900 text-sm font-medium hover:bg-primary-100 transition">Gérer les événements</a>
            </div>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <article class="module-card bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-lg font-semibold text-primary-900 mb-2">Publications</h3>
            <p class="text-sm text-gray-500">Créez, modifiez et publiez des contenus. Les journalistes et community managers gèrent les publications.</p>
        </article>
        <article class="module-card bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-lg font-semibold text-primary-900 mb-2">Clients</h3>
            <p class="text-sm text-gray-500">Consultez et gérez les fiches clients pour les projets marketing et événements.</p>
        </article>
        <article class="module-card bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-lg font-semibold text-primary-900 mb-2">Événements</h3>
            <p class="text-sm text-gray-500">Planifiez et suivez les événements. Tous les rôles ont accès à ce module.</p>
        </article>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-lg font-semibold text-primary-900 mb-3">Rappels de rôle</h3>
            <ul class="space-y-3 text-sm text-gray-600">
                <li><strong>Admin</strong> : accès total à tous les modules, y compris la gestion des utilisateurs.</li>
                <li><strong>Journaliste</strong> : accès aux contenus, clients et événements, sans accès aux utilisateurs.</li>
                <li><strong>Community Manager</strong> : mêmes droits que le journaliste, avec priorité sur les commentaires et la modération.</li>
            </ul>
        </div>
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <h3 class="text-lg font-semibold text-primary-900 mb-3">Astuce</h3>
            <p class="text-sm text-gray-600">Utilise le menu latéral pour naviguer rapidement entre les modules. Le module <strong>Utilisateurs</strong> n’est visible que si tu es admin.</p>
        </div>
    </div>
</div>

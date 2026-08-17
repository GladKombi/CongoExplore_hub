<?php
$roleMeta = [
    'Admin' => [
        'label' => 'Administrateur',
        'description' => 'Acces complet a tous les modules et aux parametres de gestion.',
        'badge' => 'bg-primary-900 text-white',
        'soft' => 'bg-primary-50 text-primary-800',
        'icon' => 'shield-check',
    ],
    'Journaliste' => [
        'label' => 'Journaliste',
        'description' => 'Gestion editoriale des contenus, clients et evenements.',
        'badge' => 'bg-gold-500 text-primary-950',
        'soft' => 'bg-gold-50 text-gold-800',
        'icon' => 'newspaper',
    ],
    'Community Manager' => [
        'label' => 'Community Manager',
        'description' => 'Animation communautaire, suivi des publications et moderation.',
        'badge' => 'bg-emerald-600 text-white',
        'soft' => 'bg-emerald-50 text-emerald-800',
        'icon' => 'messages-square',
    ],
];
?>

<div class="space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Utilisateur</p>
            <h2 class="text-2xl font-bold text-primary-900 font-display"><?php echo htmlspecialchars($title ?? 'Utilisateur', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h2>
        </div>
        <a href="<?php echo BASE_URL; ?>utilisateur" class="inline-flex w-fit items-center justify-center gap-2 rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-primary-900 shadow-sm hover:bg-primary-50 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Retour aux utilisateurs
        </a>
    </div>

    <?php if (!empty($utilisateur)): ?>
        <?php
        $fullName = trim(($utilisateur['prenom'] ?? '') . ' ' . ($utilisateur['nom'] ?? '')) ?: 'Utilisateur';
        $initials = strtoupper(substr($utilisateur['prenom'] ?? 'U', 0, 1) . substr($utilisateur['nom'] ?? '', 0, 1));
        $role = $utilisateur['role'] ?? 'Journaliste';
        $meta = $roleMeta[$role] ?? [
            'label' => $role,
            'description' => 'Role personnalise.',
            'badge' => 'bg-gray-700 text-white',
            'soft' => 'bg-gray-50 text-gray-700',
            'icon' => 'user',
        ];
        $createdAt = !empty($utilisateur['date_creation']) ? date('d/m/Y a H:i', strtotime((string)$utilisateur['date_creation'])) : '-';
        $isDeleted = !empty($utilisateur['supprimer']);
        $photoUrl = !empty($utilisateur['photo_profil']) ? BASE_URL . ltrim($utilisateur['photo_profil'], '/') : null;
        ?>

        <div class="grid gap-6 xl:grid-cols-[380px_minmax(0,1fr)]">
            <aside class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                <div class="flex flex-col items-center text-center">
                    <div class="relative">
                        <?php if ($photoUrl): ?>
                            <img src="<?php echo htmlspecialchars($photoUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" alt="Photo de <?php echo htmlspecialchars($fullName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="h-28 w-28 rounded-[2rem] object-cover">
                        <?php else: ?>
                            <div class="flex h-28 w-28 items-center justify-center rounded-[2rem] bg-primary-50 text-4xl font-bold uppercase text-primary-800"><?php echo htmlspecialchars($initials, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                        <?php endif; ?>
                        <span class="absolute -bottom-2 -right-2 flex h-11 w-11 items-center justify-center rounded-2xl border-4 border-white <?php echo htmlspecialchars($meta['badge'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                            <i data-lucide="<?php echo htmlspecialchars($meta['icon'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" class="w-5 h-5"></i>
                        </span>
                    </div>
                    <h3 class="mt-6 text-2xl font-bold text-primary-900 font-display"><?php echo htmlspecialchars($fullName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></h3>
                    <p class="mt-2 text-sm text-gray-500"><?php echo htmlspecialchars($utilisateur['email'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                    <span class="mt-5 inline-flex rounded-full px-4 py-2 text-sm font-semibold <?php echo htmlspecialchars($meta['badge'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($role, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                    </span>
                </div>
            </aside>

            <section class="space-y-6">
                <div class="grid gap-6 md:grid-cols-3">
                    <article class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Identifiant</p>
                        <p class="text-2xl font-bold text-primary-900">#<?php echo htmlspecialchars((string)($utilisateur['id'] ?? '-'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                    </article>
                    <article class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Statut</p>
                        <p class="text-2xl font-bold <?php echo $isDeleted ? 'text-red-600' : 'text-emerald-600'; ?>"><?php echo $isDeleted ? 'Supprime' : 'Actif'; ?></p>
                    </article>
                    <article class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Creation</p>
                        <p class="text-lg font-bold text-primary-900"><?php echo htmlspecialchars($createdAt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                    </article>
                </div>

                <div class="bg-white rounded-3xl border border-gray-100 p-6 shadow-sm">
                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 pb-5">
                        <div>
                            <h3 class="text-lg font-semibold text-primary-900">Informations du compte</h3>
                            <p class="mt-1 text-sm text-gray-500">Coordonnees et role applicatif.</p>
                        </div>
                        <span class="hidden sm:inline-flex rounded-2xl px-3 py-2 text-xs font-semibold <?php echo htmlspecialchars($meta['soft'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                            <?php echo htmlspecialchars($meta['label'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                        </span>
                    </div>

                    <dl class="mt-6 grid gap-4 md:grid-cols-2">
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <dt class="text-xs uppercase tracking-[0.18em] text-gray-400">Nom</dt>
                            <dd class="mt-2 text-sm font-semibold text-primary-900"><?php echo htmlspecialchars($utilisateur['nom'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></dd>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4">
                            <dt class="text-xs uppercase tracking-[0.18em] text-gray-400">Prenom</dt>
                            <dd class="mt-2 text-sm font-semibold text-primary-900"><?php echo htmlspecialchars($utilisateur['prenom'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></dd>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4 md:col-span-2">
                            <dt class="text-xs uppercase tracking-[0.18em] text-gray-400">Email professionnel</dt>
                            <dd class="mt-2 break-all text-sm font-semibold text-primary-900"><?php echo htmlspecialchars($utilisateur['email'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></dd>
                        </div>
                        <div class="rounded-2xl bg-gray-50 p-4 md:col-span-2">
                            <dt class="text-xs uppercase tracking-[0.18em] text-gray-400">Permissions</dt>
                            <dd class="mt-2 text-sm text-gray-600"><?php echo htmlspecialchars($meta['description'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></dd>
                        </div>
                    </dl>
                </div>
            </section>
        </div>
    <?php else: ?>
        <section class="bg-white rounded-3xl border border-gray-100 p-10 text-center shadow-sm">
            <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-3xl bg-red-50 text-red-600">
                <i data-lucide="user-x" class="w-7 h-7"></i>
            </div>
            <h3 class="text-xl font-bold text-primary-900 font-display">Utilisateur introuvable</h3>
            <p class="mt-2 text-sm text-gray-500">Le compte demande n'existe pas ou a ete supprime.</p>
            <a href="<?php echo BASE_URL; ?>utilisateur" class="mt-6 inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                Retour aux utilisateurs
            </a>
        </section>
    <?php endif; ?>
</div>

<script>
    if (typeof renderIcons === 'function') renderIcons();
</script>

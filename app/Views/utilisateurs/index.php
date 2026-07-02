<?php
$utilisateurs = $utilisateurs ?? [];
$roles = ['Admin', 'Journaliste', 'Community Manager'];

$roleMeta = [
    'Admin' => [
        'description' => 'Acces complet a tous les modules, y compris la gestion des utilisateurs.',
        'tone' => 'bg-primary-900 text-white',
        'soft' => 'bg-primary-50 text-primary-800 border-primary-100',
    ],
    'Journaliste' => [
        'description' => 'Gestion des publications, clients et evenements, sans administration des comptes.',
        'tone' => 'bg-gold-500 text-primary-950',
        'soft' => 'bg-gold-50 text-gold-800 border-gold-100',
    ],
    'Community Manager' => [
        'description' => 'Suivi des contenus, clients et evenements avec un focus animation communautaire.',
        'tone' => 'bg-emerald-600 text-white',
        'soft' => 'bg-emerald-50 text-emerald-800 border-emerald-100',
    ],
];

$totalUsers = count($utilisateurs);
$activeUsers = count(array_filter($utilisateurs, static fn($u) => empty($u['supprimer'])));
$adminUsers = count(array_filter($utilisateurs, static fn($u) => ($u['role'] ?? '') === 'Admin'));
$latestUsers = $utilisateurs;
usort($latestUsers, static fn($a, $b) => strcmp((string)($b['date_creation'] ?? ''), (string)($a['date_creation'] ?? '')));
$latestUsers = array_slice($latestUsers, 0, 3);
?>

<div class="space-y-6" id="users-page">
    <style>
        #users-page .users-tab.active {
            background: #0a1c17;
            color: #fff;
            border-color: #0a1c17;
        }

        #users-page .users-view[hidden],
        #user-modal[hidden],
        #delete-modal[hidden] {
            display: none;
        }

        #users-page .modal-shell {
            animation: usersModalIn 180ms cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes usersModalIn {
            from { opacity: 0; transform: translateY(12px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>

    <?php if (!empty($_SESSION['toast'])): ?>
        <?php $toast = $_SESSION['toast']; unset($_SESSION['toast']); ?>
        <div class="fixed right-6 top-20 z-50 flex items-center gap-3 rounded-2xl px-5 py-4 text-sm font-semibold shadow-2xl <?php echo ($toast['type'] ?? '') === 'error' ? 'bg-red-600 text-white' : 'bg-primary-900 text-white'; ?>">
            <i data-lucide="<?php echo ($toast['type'] ?? '') === 'error' ? 'circle-alert' : 'circle-check'; ?>" class="w-5 h-5"></i>
            <span><?php echo htmlspecialchars($toast['message'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
        </div>
    <?php endif; ?>

    <div class="grid gap-6 lg:grid-cols-4">
        <section class="lg:col-span-2 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Administration</p>
                    <h2 class="text-2xl font-bold text-primary-900 font-display">Gestion des utilisateurs</h2>
                    <p class="text-sm text-gray-500 mt-2 max-w-xl">Pilote les acces internes, controle les roles et garde une lecture rapide de l'equipe.</p>
                </div>
                <button type="button" onclick="openUserModal()" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition">
                    <i data-lucide="user-plus" class="w-4 h-4"></i>
                    Ajouter
                </button>
            </div>
        </section>

        <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Comptes</p>
            <p class="text-3xl font-bold text-primary-900"><?php echo htmlspecialchars((string)$totalUsers, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
            <p class="text-sm text-gray-500 mt-2"><?php echo htmlspecialchars((string)$activeUsers, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> actif(s)</p>
        </section>

        <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Admins</p>
            <p class="text-3xl font-bold text-primary-900"><?php echo htmlspecialchars((string)$adminUsers, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
            <p class="text-sm text-gray-500 mt-2">Acces complet</p>
        </section>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
        <section class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div class="inline-flex w-fit rounded-2xl border border-gray-100 bg-gray-50 p-1">
                        <button type="button" class="users-tab active rounded-xl px-4 py-2 text-sm font-semibold text-gray-600 transition" data-view="utilisateurs">Utilisateurs</button>
                        <button type="button" class="users-tab rounded-xl px-4 py-2 text-sm font-semibold text-gray-600 transition" data-view="roles">Roles</button>
                    </div>
                    <div class="relative w-full lg:w-80">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input id="users-search" type="search" oninput="filterUsersTable()" placeholder="Rechercher..." class="form-input w-full rounded-2xl border border-gray-200 bg-gray-50 py-3 pl-10 pr-4 text-sm outline-none focus:border-gold-500/50 focus:bg-white">
                    </div>
                </div>
            </div>

            <div id="view-utilisateurs" class="users-view overflow-x-auto">
                <table class="w-full min-w-[760px] text-left">
                    <thead class="bg-gray-50 text-xs uppercase tracking-[0.18em] text-gray-400">
                        <tr>
                            <th class="px-5 py-4 font-semibold">Utilisateur</th>
                            <th class="px-5 py-4 font-semibold">Email</th>
                            <th class="px-5 py-4 font-semibold">Role</th>
                            <th class="px-5 py-4 font-semibold">Creation</th>
                            <th class="px-5 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-utilisateurs" class="divide-y divide-gray-100 text-sm">
                        <?php if (!empty($utilisateurs)): ?>
                            <?php foreach ($utilisateurs as $u): ?>
                                <?php
                                $fullName = trim(($u['prenom'] ?? '') . ' ' . ($u['nom'] ?? '')) ?: ($u['nom'] ?? 'Utilisateur');
                                $initials = strtoupper(substr($u['prenom'] ?? 'U', 0, 1) . substr($u['nom'] ?? '', 0, 1));
                                $role = $u['role'] ?? 'Journaliste';
                                $searchData = strtolower(trim($fullName . ' ' . ($u['email'] ?? '') . ' ' . $role));
                                $createdAt = !empty($u['date_creation']) ? date('d/m/Y', strtotime((string)$u['date_creation'])) : '-';
                                ?>
                                <tr class="hover:bg-gray-50/80 transition" data-search="<?php echo htmlspecialchars($searchData, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-11 h-11 rounded-2xl bg-primary-50 text-primary-700 flex items-center justify-center font-bold uppercase">
                                                <?php echo htmlspecialchars($initials, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-primary-900"><?php echo htmlspecialchars($fullName, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                                                <div class="text-xs text-gray-400">ID #<?php echo htmlspecialchars((string)($u['id'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($u['email'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold <?php echo htmlspecialchars($roleMeta[$role]['soft'] ?? 'bg-gray-50 text-gray-700 border-gray-100', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($role, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-gray-500"><?php echo htmlspecialchars($createdAt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                    <td class="px-5 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="<?php echo BASE_URL; ?>utilisateur/show/<?php echo urlencode((string)($u['id'] ?? '')); ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-primary-50 hover:text-primary-800 transition" title="Voir">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            <button type="button" onclick='openUserModal(<?php echo json_encode($u, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>)' class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-gold-50 hover:text-gold-700 transition" title="Modifier">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button type="button" onclick='openDeleteModal(<?php echo json_encode((string)($u['id'] ?? ''), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>, <?php echo json_encode($fullName, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>)' class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600 transition" title="Supprimer">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr data-empty="true">
                                <td colspan="5" class="px-5 py-14 text-center">
                                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-3xl bg-primary-50 text-primary-700">
                                        <i data-lucide="users" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-semibold text-primary-900">Aucun utilisateur</p>
                                    <p class="text-sm text-gray-500 mt-1">Ajoute un premier compte pour commencer.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="view-roles" class="users-view overflow-x-auto" hidden>
                <table class="w-full min-w-[640px] text-left">
                    <thead class="bg-gray-50 text-xs uppercase tracking-[0.18em] text-gray-400">
                        <tr>
                            <th class="px-5 py-4 font-semibold">Role</th>
                            <th class="px-5 py-4 font-semibold">Description</th>
                            <th class="px-5 py-4 font-semibold">Utilisateurs</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-roles" class="divide-y divide-gray-100 text-sm">
                        <?php foreach ($roles as $role): ?>
                            <?php
                            $countUsers = count(array_filter($utilisateurs, static fn($u) => ($u['role'] ?? '') === $role));
                            $searchData = strtolower($role . ' ' . ($roleMeta[$role]['description'] ?? ''));
                            ?>
                            <tr class="hover:bg-gray-50/80 transition" data-search="<?php echo htmlspecialchars($searchData, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                <td class="px-5 py-4">
                                    <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold <?php echo htmlspecialchars($roleMeta[$role]['tone'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($role, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($roleMeta[$role]['description'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                <td class="px-5 py-4 font-semibold text-primary-900"><?php echo htmlspecialchars((string)$countUsers, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="space-y-6">
            <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-primary-900">Derniers ajouts</h3>
                    <i data-lucide="clock-3" class="w-5 h-5 text-gold-600"></i>
                </div>
                <div class="space-y-4">
                    <?php if (!empty($latestUsers)): ?>
                        <?php foreach ($latestUsers as $u): ?>
                            <?php
                            $name = trim(($u['prenom'] ?? '') . ' ' . ($u['nom'] ?? '')) ?: 'Utilisateur';
                            $date = !empty($u['date_creation']) ? date('d/m/Y', strtotime((string)$u['date_creation'])) : '-';
                            ?>
                            <div class="flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-primary-900"><?php echo htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo htmlspecialchars($u['role'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                </div>
                                <span class="text-xs text-gray-400"><?php echo htmlspecialchars($date, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">Aucun compte recent.</p>
                    <?php endif; ?>
                </div>
            </section>

            <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-semibold text-primary-900 mb-3">Rappels</h3>
                <div class="space-y-3 text-sm text-gray-600">
                    <?php foreach ($roles as $role): ?>
                        <p><strong class="text-primary-900"><?php echo htmlspecialchars($role, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></strong> : <?php echo htmlspecialchars($roleMeta[$role]['description'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                    <?php endforeach; ?>
                </div>
            </section>
        </aside>
    </div>

    <div id="user-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/40 px-4 backdrop-blur-sm" hidden>
        <div class="modal-shell w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Compte</p>
                    <h3 id="user-modal-title" class="text-xl font-bold text-primary-900 font-display">Ajouter un utilisateur</h3>
                </div>
                <button type="button" onclick="closeModal('user-modal')" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="user-form" class="space-y-4" method="POST" action="<?php echo BASE_URL; ?>utilisateur/create">
                <input type="hidden" id="user-id" name="id">
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block">
                        <span class="text-sm font-semibold text-gray-700">Prenom</span>
                        <input id="user-prenom" name="prenom" type="text" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-gray-700">Nom</span>
                        <input id="user-nom" name="nom" type="text" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                    </label>
                </div>
                <label class="block">
                    <span class="text-sm font-semibold text-gray-700">Role</span>
                    <select id="user-role" name="role" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo htmlspecialchars($role, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($role, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label class="block">
                    <span class="text-sm font-semibold text-gray-700">Mot de passe</span>
                    <input id="user-password" name="mot_de_passe" type="password" minlength="4" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" autocomplete="new-password">
                    <span id="password-help" class="mt-2 block text-xs text-gray-400">Minimum 4 caracteres.</span>
                </label>
                <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                    <button type="button" onclick="closeModal('user-modal')" class="rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Annuler</button>
                    <button type="submit" class="rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/40 px-4 backdrop-blur-sm" hidden>
        <div class="modal-shell w-full max-w-md rounded-3xl bg-white p-6 text-center shadow-2xl">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-3xl bg-red-50 text-red-600">
                <i data-lucide="triangle-alert" class="w-6 h-6"></i>
            </div>
            <h3 class="text-xl font-bold text-primary-900 font-display">Confirmer la suppression</h3>
            <p class="mt-3 text-sm text-gray-500">Vous etes sur le point de desactiver <strong id="delete-user-name" class="text-primary-900"></strong>.</p>
            <form method="POST" action="<?php echo BASE_URL; ?>utilisateur/delete" class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-center">
                <input type="hidden" id="delete-user-id" name="id">
                <button type="button" onclick="closeModal('delete-modal')" class="rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Annuler</button>
                <button type="submit" class="rounded-2xl bg-red-600 px-4 py-3 text-sm font-semibold text-white hover:bg-red-700 transition">Supprimer</button>
            </form>
        </div>
    </div>
</div>

<script>
    let currentUsersView = 'utilisateurs';

    document.querySelectorAll('#users-page .users-tab').forEach((button) => {
        button.addEventListener('click', () => {
            currentUsersView = button.dataset.view;
            document.querySelectorAll('#users-page .users-tab').forEach((tab) => tab.classList.remove('active'));
            button.classList.add('active');
            document.getElementById('view-utilisateurs').hidden = currentUsersView !== 'utilisateurs';
            document.getElementById('view-roles').hidden = currentUsersView !== 'roles';
            document.getElementById('users-search').value = '';
            filterUsersTable();
        });
    });

    function filterUsersTable() {
        const query = document.getElementById('users-search').value.toLowerCase().trim();
        const tbody = document.getElementById(currentUsersView === 'utilisateurs' ? 'tbody-utilisateurs' : 'tbody-roles');

        tbody.querySelectorAll('tr').forEach((row) => {
            if (row.dataset.empty) return;
            row.hidden = query.length > 0 && !(row.dataset.search || '').includes(query);
        });
    }

    function openModal(id) {
        document.getElementById(id).hidden = false;
        document.body.classList.add('overflow-hidden');
        if (typeof renderIcons === 'function') renderIcons();
    }

    function closeModal(id) {
        document.getElementById(id).hidden = true;
        document.body.classList.remove('overflow-hidden');
    }

    function openUserModal(user = null) {
        const form = document.getElementById('user-form');
        const password = document.getElementById('user-password');
        const passwordHelp = document.getElementById('password-help');

        form.reset();
        form.action = user ? '<?php echo BASE_URL; ?>utilisateur/update' : '<?php echo BASE_URL; ?>utilisateur/create';
        document.getElementById('user-id').value = user?.id || '';
        document.getElementById('user-prenom').value = user?.prenom || '';
        document.getElementById('user-nom').value = user?.nom || '';
        document.getElementById('user-role').value = user?.role || 'Journaliste';
        document.getElementById('user-modal-title').textContent = user ? 'Modifier un utilisateur' : 'Ajouter un utilisateur';
        password.required = !user;
        passwordHelp.textContent = user ? 'Laissez vide pour conserver le mot de passe actuel.' : 'Minimum 4 caracteres.';
        openModal('user-modal');
    }

    function openDeleteModal(id, name) {
        document.getElementById('delete-user-id').value = id;
        document.getElementById('delete-user-name').textContent = name;
        openModal('delete-modal');
    }

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        closeModal('user-modal');
        closeModal('delete-modal');
    });

    ['user-modal', 'delete-modal'].forEach((id) => {
        document.getElementById(id).addEventListener('click', (event) => {
            if (event.target.id === id) closeModal(id);
        });
    });

    if (typeof renderIcons === 'function') renderIcons();
</script>

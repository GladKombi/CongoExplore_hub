<?php
$contenus = $contenus ?? [];
$categories = $categories ?? [];
$statuses = ['Brouillon', 'Publie', 'Archive'];

$statusMeta = [
    'Brouillon' => ['label' => 'Brouillon', 'badge' => 'bg-gray-100 text-gray-700 border-gray-200', 'tone' => 'bg-gray-700 text-white'],
    'Publie' => ['label' => 'Publie', 'badge' => 'bg-emerald-50 text-emerald-800 border-emerald-100', 'tone' => 'bg-emerald-600 text-white'],
    'Archive' => ['label' => 'Archive', 'badge' => 'bg-gold-50 text-gold-800 border-gold-100', 'tone' => 'bg-gold-500 text-primary-950'],
];

$totalContents = count($contenus);
$publishedCount = count(array_filter($contenus, static fn($c) => ($c['statut'] ?? '') === 'Publie'));
$draftCount = count(array_filter($contenus, static fn($c) => ($c['statut'] ?? '') === 'Brouillon'));
$totalViews = array_sum(array_map(static fn($c) => (int)($c['vues'] ?? 0), $contenus));
$latestContents = array_slice($contenus, 0, 3);
?>

<div class="space-y-6" id="contents-page">
    <style>
        #contents-page .content-tab.active {
            background: #0a1c17;
            color: #fff;
            border-color: #0a1c17;
        }

        #content-modal[hidden],
        #delete-content-modal[hidden] {
            display: none;
        }

        #contents-page .modal-shell {
            animation: contentModalIn 180ms cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes contentModalIn {
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

    <nav class="flex flex-wrap items-center gap-2 text-sm">
        <span class="inline-flex items-center gap-2 rounded-2xl bg-primary-900 px-4 py-2 font-semibold text-white shadow-sm">
            <i data-lucide="newspaper" class="w-4 h-4"></i>
            Publications
        </span>
        <a href="<?php echo BASE_URL; ?>media" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition">
            <i data-lucide="image" class="w-4 h-4"></i>
            Medias
        </a>
        <a href="<?php echo BASE_URL; ?>categorie" class="inline-flex items-center gap-2 rounded-2xl border border-gray-100 bg-white px-4 py-2 font-semibold text-gray-600 shadow-sm hover:text-primary-900 transition">
            <i data-lucide="folder" class="w-4 h-4"></i>
            Categories
        </a>
    </nav>

    <div class="grid gap-6 lg:grid-cols-4">
        <section class="lg:col-span-2 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Media</p>
                    <h2 class="text-2xl font-bold text-primary-900 font-display">Gestion des publications</h2>
                    <p class="text-sm text-gray-500 mt-2 max-w-xl">Cree, organise et publie les contenus editoriaux du hub.</p>
                </div>
                <button type="button" onclick="openContentModal()" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nouvelle publication
                </button>
            </div>
        </section>

        <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Publiees</p>
            <p class="text-3xl font-bold text-primary-900"><?php echo htmlspecialchars((string)$publishedCount, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
            <p class="text-sm text-gray-500 mt-2"><?php echo htmlspecialchars((string)$draftCount, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> brouillon(s)</p>
        </section>

        <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
            <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Vues</p>
            <p class="text-3xl font-bold text-primary-900"><?php echo htmlspecialchars((string)$totalViews, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
            <p class="text-sm text-gray-500 mt-2"><?php echo htmlspecialchars((string)$totalContents, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> contenu(s)</p>
        </section>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_320px]">
        <section class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                    <div class="inline-flex w-fit flex-wrap rounded-2xl border border-gray-100 bg-gray-50 p-1">
                        <button type="button" class="content-tab active rounded-xl px-4 py-2 text-sm font-semibold text-gray-600 transition" data-status="all">Tout</button>
                        <?php foreach ($statuses as $status): ?>
                            <button type="button" class="content-tab rounded-xl px-4 py-2 text-sm font-semibold text-gray-600 transition" data-status="<?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($statusMeta[$status]['label'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="relative w-full xl:w-80">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                        <input id="contents-search" type="search" oninput="filterContentsTable()" placeholder="Rechercher..." class="form-input w-full rounded-2xl border border-gray-200 bg-gray-50 py-3 pl-10 pr-4 text-sm outline-none focus:border-gold-500/50 focus:bg-white">
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[880px] text-left">
                    <thead class="bg-gray-50 text-xs uppercase tracking-[0.18em] text-gray-400">
                        <tr>
                            <th class="px-5 py-4 font-semibold">Publication</th>
                            <th class="px-5 py-4 font-semibold">Categorie</th>
                            <th class="px-5 py-4 font-semibold">Statut</th>
                            <th class="px-5 py-4 font-semibold">Engagement</th>
                            <th class="px-5 py-4 font-semibold">Vues</th>
                            <th class="px-5 py-4 font-semibold">Publication</th>
                            <th class="px-5 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-contents" class="divide-y divide-gray-100 text-sm">
                        <?php if (!empty($contenus)): ?>
                            <?php foreach ($contenus as $contenu): ?>
                                <?php
                                $status = $contenu['statut'] ?? 'Brouillon';
                                $author = trim(($contenu['auteur_prenom'] ?? '') . ' ' . ($contenu['auteur_nom'] ?? '')) ?: 'Auteur inconnu';
                                $publishedAt = !empty($contenu['date_publication']) ? date('d/m/Y', strtotime((string)$contenu['date_publication'])) : '-';
                                $searchData = strtolower(trim(($contenu['titre'] ?? '') . ' ' . ($contenu['categorie_nom'] ?? '') . ' ' . $status . ' ' . $author));
                                ?>
                                <tr class="hover:bg-gray-50/80 transition" data-status="<?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" data-search="<?php echo htmlspecialchars($searchData, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                                                <i data-lucide="file-text" class="w-5 h-5"></i>
                                            </div>
                                            <div class="min-w-0">
                                                <div class="max-w-[300px] truncate font-semibold text-primary-900"><?php echo htmlspecialchars($contenu['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                                                <div class="text-xs text-gray-400">Par <?php echo htmlspecialchars($author, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($contenu['categorie_nom'] ?? 'Sans categorie', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                    <td class="px-5 py-4">
                                        <span class="inline-flex rounded-full border px-3 py-1 text-xs font-semibold <?php echo htmlspecialchars($statusMeta[$status]['badge'] ?? 'bg-gray-50 text-gray-700 border-gray-100', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                            <?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap gap-2 text-xs font-semibold text-gray-500">
                                            <span class="rounded-full bg-red-50 px-2 py-1 text-red-600"><?php echo htmlspecialchars((string)($contenu['likes_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> likes</span>
                                            <span class="rounded-full bg-primary-50 px-2 py-1 text-primary-700"><?php echo htmlspecialchars((string)($contenu['commentaires_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> com.</span>
                                            <span class="rounded-full bg-gold-50 px-2 py-1 text-gold-700"><?php echo htmlspecialchars((string)($contenu['partages_count'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> part.</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-primary-900"><?php echo htmlspecialchars((string)($contenu['vues'] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                    <td class="px-5 py-4 text-gray-500"><?php echo htmlspecialchars($publishedAt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                    <td class="px-5 py-4">
                                        <div class="flex justify-end gap-2">
                                            <a href="<?php echo BASE_URL; ?>contenu/show/<?php echo urlencode((string)($contenu['id'] ?? '')); ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-primary-50 hover:text-primary-800 transition" title="Voir">
                                                <i data-lucide="eye" class="w-4 h-4"></i>
                                            </a>
                                            <button type="button" onclick='openContentModal(<?php echo json_encode($contenu, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>)' class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-gold-50 hover:text-gold-700 transition" title="Modifier">
                                                <i data-lucide="pencil" class="w-4 h-4"></i>
                                            </button>
                                            <button type="button" onclick='openDeleteContentModal(<?php echo json_encode((string)($contenu['id'] ?? ''), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>, <?php echo json_encode($contenu['titre'] ?? '', JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>)' class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600 transition" title="Supprimer">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr data-empty="true">
                                <td colspan="6" class="px-5 py-14 text-center">
                                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-3xl bg-primary-50 text-primary-700">
                                        <i data-lucide="file-text" class="w-6 h-6"></i>
                                    </div>
                                    <p class="font-semibold text-primary-900">Aucune publication</p>
                                    <p class="text-sm text-gray-500 mt-1">Cree un premier contenu pour commencer.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="space-y-6">
            <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-primary-900">Recents</h3>
                    <i data-lucide="clock-3" class="w-5 h-5 text-gold-600"></i>
                </div>
                <div class="space-y-4">
                    <?php if (!empty($latestContents)): ?>
                        <?php foreach ($latestContents as $contenu): ?>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-semibold text-primary-900"><?php echo htmlspecialchars($contenu['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                <p class="text-xs text-gray-500"><?php echo htmlspecialchars(($contenu['statut'] ?? '-') . ' - ' . ($contenu['categorie_nom'] ?? 'Sans categorie'), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-sm text-gray-500">Aucun contenu recent.</p>
                    <?php endif; ?>
                </div>
            </section>

            <section class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-semibold text-primary-900 mb-3">Statuts</h3>
                <div class="space-y-3">
                    <?php foreach ($statuses as $status): ?>
                        <?php $count = count(array_filter($contenus, static fn($c) => ($c['statut'] ?? '') === $status)); ?>
                        <div class="flex items-center justify-between gap-3 rounded-2xl bg-gray-50 px-4 py-3">
                            <span class="text-sm font-semibold text-primary-900"><?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                            <span class="text-sm text-gray-500"><?php echo htmlspecialchars((string)$count, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </aside>
    </div>

    <div id="content-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/40 px-4 backdrop-blur-sm" hidden>
        <div class="modal-shell max-h-[90vh] w-full max-w-3xl overflow-y-auto rounded-3xl bg-white p-6 shadow-2xl">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <p class="text-xs uppercase tracking-[0.24em] text-gray-400 mb-2">Publication</p>
                    <h3 id="content-modal-title" class="text-xl font-bold text-primary-900 font-display">Nouvelle publication</h3>
                </div>
                <button type="button" onclick="closeContentModal('content-modal')" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl text-gray-400 hover:bg-gray-50 hover:text-gray-700 transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="content-form" method="POST" action="<?php echo BASE_URL; ?>contenu/create" class="space-y-4">
                <input type="hidden" id="content-id" name="id">
                <label class="block">
                    <span class="text-sm font-semibold text-gray-700">Titre</span>
                    <input id="content-title" name="titre" type="text" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                </label>
                <div class="grid gap-4 sm:grid-cols-3">
                    <label class="block">
                        <span class="text-sm font-semibold text-gray-700">Categorie</span>
                        <select id="content-category" name="categorie_id" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                            <option value="">Choisir</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars((string)$category['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($category['nom'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-gray-700">Statut</span>
                        <select id="content-status" name="statut" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                            <?php foreach ($statuses as $status): ?>
                                <option value="<?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($status, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                    <label class="block">
                        <span class="text-sm font-semibold text-gray-700">Date publication</span>
                        <input id="content-date" name="date_publication" type="datetime-local" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none">
                    </label>
                </div>
                <label class="block">
                    <span class="text-sm font-semibold text-gray-700">Corps du contenu</span>
                    <textarea id="content-body" name="corps_text" rows="9" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></textarea>
                </label>
                <?php if (empty($categories)): ?>
                    <p class="rounded-2xl bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">Ajoute au moins une categorie dans la base avant de creer une publication.</p>
                <?php endif; ?>
                <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">
                    <button type="button" onclick="closeContentModal('content-modal')" class="rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Annuler</button>
                    <button type="submit" class="rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition" <?php echo empty($categories) ? 'disabled' : ''; ?>>Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <div id="delete-content-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/40 px-4 backdrop-blur-sm" hidden>
        <div class="modal-shell w-full max-w-md rounded-3xl bg-white p-6 text-center shadow-2xl">
            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-3xl bg-red-50 text-red-600">
                <i data-lucide="triangle-alert" class="w-6 h-6"></i>
            </div>
            <h3 class="text-xl font-bold text-primary-900 font-display">Supprimer la publication</h3>
            <p class="mt-3 text-sm text-gray-500">Vous etes sur le point de supprimer <strong id="delete-content-title" class="text-primary-900"></strong>.</p>
            <form method="POST" action="<?php echo BASE_URL; ?>contenu/delete" class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-center">
                <input type="hidden" id="delete-content-id" name="id">
                <button type="button" onclick="closeContentModal('delete-content-modal')" class="rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">Annuler</button>
                <button type="submit" class="rounded-2xl bg-red-600 px-4 py-3 text-sm font-semibold text-white hover:bg-red-700 transition">Supprimer</button>
            </form>
        </div>
    </div>
</div>

<script>
    let currentContentStatus = 'all';

    document.querySelectorAll('#contents-page .content-tab').forEach((button) => {
        button.addEventListener('click', () => {
            currentContentStatus = button.dataset.status;
            document.querySelectorAll('#contents-page .content-tab').forEach((tab) => tab.classList.remove('active'));
            button.classList.add('active');
            filterContentsTable();
        });
    });

    function filterContentsTable() {
        const query = document.getElementById('contents-search').value.toLowerCase().trim();
        document.querySelectorAll('#tbody-contents tr').forEach((row) => {
            if (row.dataset.empty) return;
            const matchesStatus = currentContentStatus === 'all' || row.dataset.status === currentContentStatus;
            const matchesSearch = query.length === 0 || (row.dataset.search || '').includes(query);
            row.hidden = !matchesStatus || !matchesSearch;
        });
    }

    function openContentOverlay(id) {
        document.getElementById(id).hidden = false;
        document.body.classList.add('overflow-hidden');
        if (typeof renderIcons === 'function') renderIcons();
    }

    function closeContentModal(id) {
        document.getElementById(id).hidden = true;
        document.body.classList.remove('overflow-hidden');
    }

    function toDateTimeLocal(value) {
        if (!value) return '';
        return String(value).replace(' ', 'T').slice(0, 16);
    }

    function openContentModal(content = null) {
        const form = document.getElementById('content-form');
        form.reset();
        form.action = content ? '<?php echo BASE_URL; ?>contenu/update' : '<?php echo BASE_URL; ?>contenu/create';
        document.getElementById('content-id').value = content?.id || '';
        document.getElementById('content-title').value = content?.titre || '';
        document.getElementById('content-category').value = content?.categorie_id || '';
        document.getElementById('content-status').value = content?.statut || 'Brouillon';
        document.getElementById('content-date').value = toDateTimeLocal(content?.date_publication || '');
        document.getElementById('content-body').value = content?.corps_text || '';
        document.getElementById('content-modal-title').textContent = content ? 'Modifier la publication' : 'Nouvelle publication';
        openContentOverlay('content-modal');
    }

    function openDeleteContentModal(id, title) {
        document.getElementById('delete-content-id').value = id;
        document.getElementById('delete-content-title').textContent = title;
        openContentOverlay('delete-content-modal');
    }

    document.addEventListener('keydown', (event) => {
        if (event.key !== 'Escape') return;
        closeContentModal('content-modal');
        closeContentModal('delete-content-modal');
    });

    ['content-modal', 'delete-content-modal'].forEach((id) => {
        document.getElementById(id).addEventListener('click', (event) => {
            if (event.target.id === id) closeContentModal(id);
        });
    });

    if (typeof renderIcons === 'function') renderIcons();
</script>

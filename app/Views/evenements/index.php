<?php
$evenements = $evenements ?? [];
$clients = $clients ?? [];
$medias = $medias ?? [];
$types = ['Interne', 'Client'];
$mediaTypes = ['Photo', 'Video', 'Interview', 'Reportage'];
$mediaCounts = [];

foreach ($medias as $media) {
    $eventId = (int)($media['evenement_id'] ?? 0);
    $mediaCounts[$eventId] = ($mediaCounts[$eventId] ?? 0) + 1;
}

$totalEvents = count($evenements);
$clientEvents = count(array_filter($evenements, static fn($e) => ($e['type_evenement'] ?? '') === 'Client'));
$internalEvents = count(array_filter($evenements, static fn($e) => ($e['type_evenement'] ?? '') === 'Interne'));
?>

<div class="space-y-6" id="events-page">
    <style>
        #event-modal[hidden] {
            display: none !important;
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
        <section class="lg:col-span-2 rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Live coverage</p>
                    <h2 class="font-display text-2xl font-bold text-primary-900">Gestion des evenements</h2>
                    <p class="mt-2 max-w-xl text-sm text-gray-500">Planifie les evenements internes ou clients, puis rattache leurs medias.</p>
                </div>
                <button type="button" onclick="openEventModal()" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Nouvel evenement
                </button>
            </div>
        </section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Clients</p>
            <p class="text-3xl font-bold text-primary-900"><?php echo htmlspecialchars((string)$clientEvents, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
            <p class="mt-2 text-sm text-gray-500">evenement(s)</p>
        </section>
        <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
            <p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Internes</p>
            <p class="text-3xl font-bold text-primary-900"><?php echo htmlspecialchars((string)$internalEvents, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
            <p class="mt-2 text-sm text-gray-500"><?php echo htmlspecialchars((string)$totalEvents, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?> total</p>
        </section>
    </div>

    <section class="rounded-3xl border border-gray-100 bg-white p-6 shadow-sm">
        <div class="mb-5 flex items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-primary-900">Ajouter un media d’evenement</h3>
                <p class="mt-1 text-sm text-gray-500">Chaque evenement peut recevoir 3 medias maximum.</p>
            </div>
            <i data-lucide="image-plus" class="h-6 w-6 text-gold-600"></i>
        </div>
        <form method="POST" action="<?php echo BASE_URL; ?>evenement/addMedia" enctype="multipart/form-data" class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_180px_minmax(0,1fr)_220px_auto] xl:items-end">
            <label class="block">
                <span class="text-sm font-semibold text-gray-700">Evenement</span>
                <select name="evenement_id" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                    <option value="">Choisir un evenement</option>
                    <?php foreach ($evenements as $event): ?>
                        <?php $eventId = (int)($event['id'] ?? 0); $count = $mediaCounts[$eventId] ?? 0; ?>
                        <option value="<?php echo htmlspecialchars((string)$eventId, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" <?php echo $count >= 3 ? 'disabled' : ''; ?>>
                            <?php echo htmlspecialchars(($event['titre'] ?? '-') . ' (' . $count . '/3)', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-semibold text-gray-700">Type</span>
                <select name="type_media" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required>
                    <?php foreach ($mediaTypes as $type): ?>
                        <option value="<?php echo htmlspecialchars($type, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($type, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label class="block">
                <span class="text-sm font-semibold text-gray-700">Image</span>
                <input id="event-media-file" name="fichier_media" type="file" accept="image/jpeg,image/png,image/webp,image/gif" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-2.5 text-sm outline-none file:mr-3 file:rounded-xl file:border-0 file:bg-primary-900 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white" required>
            </label>
            <div class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 p-3">
                <div id="event-media-preview-empty" class="flex h-24 items-center justify-center text-center text-xs font-semibold text-gray-400">Apercu image</div>
                <img id="event-media-preview" src="" alt="Apercu du media" class="hidden h-24 w-full rounded-xl object-cover">
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800 transition">
                <i data-lucide="plus" class="h-4 w-4"></i>
                Ajouter
            </button>
        </form>
    </section>

    <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="border-b border-gray-100 p-5">
            <div class="relative max-w-md">
                <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"></i>
                <input id="event-search" oninput="filterEvents()" type="search" placeholder="Rechercher un evenement..." class="form-input w-full rounded-2xl border border-gray-200 bg-gray-50 py-3 pl-10 pr-4 text-sm outline-none">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[980px] text-left">
                <thead class="bg-gray-50 text-xs uppercase tracking-[0.18em] text-gray-400">
                    <tr>
                        <th class="px-5 py-4 font-semibold">Evenement</th>
                        <th class="px-5 py-4 font-semibold">Type</th>
                        <th class="px-5 py-4 font-semibold">Dates</th>
                        <th class="px-5 py-4 font-semibold">Lieu</th>
                        <th class="px-5 py-4 font-semibold">Medias</th>
                        <th class="px-5 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody id="events-table" class="divide-y divide-gray-100 text-sm">
                    <?php if (!empty($evenements)): ?>
                        <?php foreach ($evenements as $event): ?>
                            <?php
                            $eventId = (int)($event['id'] ?? 0);
                            $search = strtolower(trim(($event['titre'] ?? '') . ' ' . ($event['lieu'] ?? '') . ' ' . ($event['type_evenement'] ?? '') . ' ' . ($event['client_nom'] ?? '')));
                            ?>
                            <tr class="hover:bg-gray-50/80 transition" data-search="<?php echo htmlspecialchars($search, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-50 text-primary-700">
                                            <i data-lucide="calendar" class="h-5 w-5"></i>
                                        </span>
                                        <div>
                                            <p class="font-semibold text-primary-900"><?php echo htmlspecialchars($event['titre'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                            <p class="text-xs text-gray-400"><?php echo htmlspecialchars($event['client_nom'] ?? 'Interne', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4"><span class="rounded-full border border-primary-100 bg-primary-50 px-3 py-1 text-xs font-semibold text-primary-800"><?php echo htmlspecialchars($event['type_evenement'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span></td>
                                <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime((string)$event['date_debut'])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?><br><span class="text-xs text-gray-400"><?php echo htmlspecialchars(date('d/m/Y H:i', strtotime((string)$event['date_fin'])), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></span></td>
                                <td class="px-5 py-4 text-gray-600"><?php echo htmlspecialchars($event['lieu'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></td>
                                <td class="px-5 py-4 font-semibold text-primary-900"><?php echo htmlspecialchars((string)($mediaCounts[$eventId] ?? 0), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>/3</td>
                                <td class="px-5 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="<?php echo BASE_URL; ?>evenement/show/<?php echo urlencode((string)$eventId); ?>" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-primary-50 hover:text-primary-800 transition"><i data-lucide="eye" class="h-4 w-4"></i></a>
                                        <button type="button" onclick='openEventModal(<?php echo json_encode($event, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>)' class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-gold-50 hover:text-gold-700 transition"><i data-lucide="pencil" class="h-4 w-4"></i></button>
                                        <form method="POST" action="<?php echo BASE_URL; ?>evenement/delete" onsubmit="return confirm('Supprimer cet evenement ?')">
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)$eventId, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                            <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600 transition"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="px-5 py-12 text-center text-sm text-gray-500">Aucun evenement.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
        <div class="border-b border-gray-100 p-5"><h3 class="text-lg font-semibold text-primary-900">Medias d’evenements</h3></div>
        <div class="grid gap-4 p-5 md:grid-cols-2 xl:grid-cols-3">
            <?php if (!empty($medias)): ?>
                <?php foreach ($medias as $media): ?>
                    <?php $mediaUrl = BASE_URL . ltrim((string)($media['url_fichier'] ?? ''), '/'); ?>
                    <article class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm">
                        <img src="<?php echo htmlspecialchars($mediaUrl, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>" alt="Media evenement" class="h-40 w-full object-cover">
                        <div class="space-y-3 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-primary-900"><?php echo htmlspecialchars($media['evenement_titre'] ?? 'Evenement', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo htmlspecialchars($media['type_media'] ?? '-', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></p>
                                </div>
                                <form method="POST" action="<?php echo BASE_URL; ?>evenement/deleteMedia" onsubmit="return confirm('Supprimer ce media ?')">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars((string)($media['id'] ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>">
                                    <button type="submit" class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-500 hover:bg-red-50 hover:text-red-600 transition"><i data-lucide="trash-2" class="h-4 w-4"></i></button>
                                </form>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-sm text-gray-500">Aucun media d’evenement.</p>
            <?php endif; ?>
        </div>
    </section>

    <div id="event-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-primary-950/40 px-4 backdrop-blur-sm" hidden>
        <div class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-3xl bg-white p-6 shadow-2xl">
            <div class="mb-6 flex items-start justify-between">
                <div><p class="mb-2 text-xs uppercase tracking-[0.24em] text-gray-400">Evenement</p><h3 id="event-modal-title" class="font-display text-xl font-bold text-primary-900">Nouvel evenement</h3></div>
                <button type="button" onclick="closeEventModal()" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl text-gray-400 hover:bg-gray-50"><i data-lucide="x" class="h-5 w-5"></i></button>
            </div>
            <form id="event-form" method="POST" action="<?php echo BASE_URL; ?>evenement/create" class="space-y-4">
                <input type="hidden" id="event-id" name="id">
                <label class="block"><span class="text-sm font-semibold text-gray-700">Titre</span><input id="event-title" name="titre" type="text" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></label>
                <label class="block"><span class="text-sm font-semibold text-gray-700">Description</span><textarea id="event-description" name="description" rows="4" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none"></textarea></label>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block"><span class="text-sm font-semibold text-gray-700">Debut</span><input id="event-start" name="date_debut" type="datetime-local" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></label>
                    <label class="block"><span class="text-sm font-semibold text-gray-700">Fin</span><input id="event-end" name="date_fin" type="datetime-local" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></label>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="block"><span class="text-sm font-semibold text-gray-700">Lieu</span><input id="event-location" name="lieu" type="text" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required></label>
                    <label class="block"><span class="text-sm font-semibold text-gray-700">Type</span><select id="event-type" name="type_evenement" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none" required><?php foreach ($types as $type): ?><option value="<?php echo htmlspecialchars($type, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($type, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option><?php endforeach; ?></select></label>
                </div>
                <label class="block"><span class="text-sm font-semibold text-gray-700">Client</span><select id="event-client" name="client_id" class="form-input mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm outline-none"><option value="">Aucun client</option><?php foreach ($clients as $client): ?><option value="<?php echo htmlspecialchars((string)$client['id'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>"><?php echo htmlspecialchars($client['nom_entreprise'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?></option><?php endforeach; ?></select></label>
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                    <button type="button" onclick="closeEventModal()" class="rounded-2xl border border-gray-200 px-4 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50">Annuler</button>
                    <button type="submit" class="rounded-2xl bg-primary-900 px-4 py-3 text-sm font-semibold text-white hover:bg-primary-800">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toDateTimeLocal(value) {
        if (!value) return '';
        return String(value).replace(' ', 'T').slice(0, 16);
    }

    function openEventModal(event = null) {
        const form = document.getElementById('event-form');
        form.reset();
        form.action = event ? '<?php echo BASE_URL; ?>evenement/update' : '<?php echo BASE_URL; ?>evenement/create';
        document.getElementById('event-id').value = event?.id || '';
        document.getElementById('event-title').value = event?.titre || '';
        document.getElementById('event-description').value = event?.description || '';
        document.getElementById('event-start').value = toDateTimeLocal(event?.date_debut || '');
        document.getElementById('event-end').value = toDateTimeLocal(event?.date_fin || '');
        document.getElementById('event-location').value = event?.lieu || '';
        document.getElementById('event-type').value = event?.type_evenement || 'Interne';
        document.getElementById('event-client').value = event?.client_id || '';
        document.getElementById('event-modal-title').textContent = event ? 'Modifier l’evenement' : 'Nouvel evenement';
        const modal = document.getElementById('event-modal');
        modal.hidden = false;
        modal.style.display = 'flex';
        document.body.classList.add('overflow-hidden');
        if (typeof renderIcons === 'function') renderIcons();
    }

    function closeEventModal() {
        const modal = document.getElementById('event-modal');
        modal.hidden = true;
        modal.style.display = 'none';
        document.body.classList.remove('overflow-hidden');
    }

    function filterEvents() {
        const query = document.getElementById('event-search').value.toLowerCase().trim();
        document.querySelectorAll('#events-table tr').forEach((row) => {
            row.hidden = query.length > 0 && !(row.dataset.search || '').includes(query);
        });
    }

    const eventMediaFile = document.getElementById('event-media-file');
    if (eventMediaFile) {
        eventMediaFile.addEventListener('change', () => {
            const file = eventMediaFile.files && eventMediaFile.files[0];
            const preview = document.getElementById('event-media-preview');
            const empty = document.getElementById('event-media-preview-empty');
            if (!file) {
                preview.src = '';
                preview.classList.add('hidden');
                empty.classList.remove('hidden');
                return;
            }
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            empty.classList.add('hidden');
        });
    }

    document.getElementById('event-modal').addEventListener('click', (event) => {
        if (event.target.id === 'event-modal') closeEventModal();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeEventModal();
    });

    if (typeof renderIcons === 'function') renderIcons();
</script>
